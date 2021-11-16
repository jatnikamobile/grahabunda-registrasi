<?php

namespace App\Console\Commands;

use App\Models\Bridging_bpjs;
use App\Models\FtDokter;
use App\Models\TBLKabupaten;
use App\Models\TBLPropinsi;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MappingBpjs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mapping {--N|no-asking}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    private $updatedCount = 0;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tbl_propinsi = 'dbBRIDGING.dbo.bpjs_propinsi';
        $tbl_kabupaten = 'dbBRIDGING.dbo.bpjs_kabupaten';
        $tbl_kecamatan = 'dbBRIDGING.dbo.bpjs_kecamatan';

        $listPropinsi = Bridging_bpjs::get_propinsi();
        $total = count($listPropinsi->list);
        $inserted = 0;

        foreach($listPropinsi->list as $propinsi) {

            DB::insert("INSERT INTO $tbl_propinsi (kode, nama) VALUES (?, ?)", [
                $propinsi->kode,
                $propinsi->nama
            ]);
            $inserted++;
            echo $propinsi->nama.PHP_EOL;

            $listKabupaten = Bridging_bpjs::get_kabupaten($propinsi->kode);
            if(empty($listKabupaten) || empty($listKabupaten->list)) continue;

            $total += count($listKabupaten->list);

            foreach ($listKabupaten->list as $kabupaten) {

                DB::insert("INSERT INTO $tbl_kabupaten (kode, kode_propinsi, nama) VALUES (?, ?, ?)", [
                    $kabupaten->kode,
                    $propinsi->kode,
                    $kabupaten->nama
                ]);
                $inserted++;
                echo $propinsi->nama.'/'.$kabupaten->nama.PHP_EOL;

                $listKecamatan = Bridging_bpjs::get_kecamatan($kabupaten->kode);
                if(empty($listKecamatan) || empty($listKecamatan->list)) continue;

                $total += count($listKabupaten->list);

                foreach ($listKecamatan->list as $kecamatan) {

                    DB::insert("INSERT INTO $tbl_kecamatan (kode, kode_kabupaten, nama) VALUES (?, ?, ?)", [
                        $kecamatan->kode,
                        $kabupaten->kode,
                        $kecamatan->nama
                    ]);
                    $inserted++;
                    echo $propinsi->nama.'/'.$kabupaten->nama.'/'.$kecamatan->nama.PHP_EOL;
                }
            }
            echo PHP_EOL;
        }
    }

    public function mapping_propinsi()
    {
        $response = Bridging_bpjs::get_propinsi();
        
        if(!$response) return;

        foreach ($response->list as $item)
        {
            $propinsi = TBLPropinsi::query()
                ->search($item->nama)
                ->whereNull('KdBPJS')
                ->get();

            if($propinsi->count() == 1)
            {
                $prop = $propinsi->first();
                $prop->KdBPJS = $item->kode;
                $prop->save();
            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function mapping_dokter()
    {
        $shouldAsking = !$this->option('no-asking');
        // dd($this->option('no-asking'));

        $response = (new Bridging_bpjs)->dokter_dpjp(1, '');

        if($response)
        {
            foreach ($response->list as $item)
            {
                $kodeDpjp = $item->kode;
                $nama = ($item->nama = trim($item->nama));
                $this->line("Coba Mapping [$kodeDpjp] $nama");
                
                // search

                $result = FtDokter::query()->select(['KdDoc', 'NmDoc', 'KdDPJP'])->search($nama)->get();
                if($result->count() > 1)
                {
                    if($shouldAsking)
                    {
                        if($this->chooseDokterToSet($result, $item))
                        {
                            continue;
                        }
                    }
                }
                elseif($result->count() == 1)
                {
                    $this->setKodeDPJP($item, $result->first());
                    continue;
                }
                
                // full search

                $terms = Arr::where(explode(' ', $nama), function($value, $key) {
                    return strlen($value) > 3;
                });

                $result = FtDokter::query()->select(['KdDoc', 'NmDoc', 'KdDPJP'])->search($terms)->get();
                if($result->count() > 1)
                {
                    if($shouldAsking)
                    {
                        if($this->chooseDokterToSet($result, $item))
                        {
                            continue;
                        }
                    }
                }
                elseif($result->count() == 1)
                {
                    $dokter = $result->first();
                    if($shouldAsking)
                    {
                        if($this->confirm("Apakah dokter [$nama] adalah [{$dokter->NmDoc}]?"))
                        {
                            $this->setKodeDPJP($item, $dokter);
                            continue;
                        }
                    }
                }
                
                $this->error('Tidak ditemukan di SIMRS');
            }
        }
        $this->line("Updated: ".$this->updatedCount);
    }

    private function setKodeDPJP($item, $dokter)
    {
        $this->info('Dokter ditemukan');
        $this->info("Set kode DPJP [{$item->kode}] untuk [{$item->nama}] ke [{$dokter->KdDoc}][{$dokter->NmDoc}]");
        $dokter->KdDPJP = $item->kode;
        $dokter->save();
        $this->updatedCount++;
    }

    private function chooseDokterToSet($resultSet, $item)
    {
        $this->info('Banyak dokter ditemukan untuk dokter '.$item->nama);
        $this->table(['Kode', 'Nama'], $resultSet->toArray());
        $choices = data_get($resultSet, '*.KdDoc');
        $choice = $this->ask("Masukkan kode dokter yg akan di set kode DPJP nya untuk dokter [{$item->nama}]");
        $dokter = $resultSet->where('KdDoc', $choice)->first();
        if($dokter)
        {
            $this->setKodeDPJP($item, $dokter);
            return true;
        }

        return false;
    }
}
