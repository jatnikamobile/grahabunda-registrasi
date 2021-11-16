<?php

namespace App\Console\Commands;

use App\Bridging\VClaim;
use App\Models\tb_dokter_mapping;
use App\Models\FtDokter;
use Illuminate\Console\Command;

class Uat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $this->test_dokter();
    }

    private function test_dokter()
    {
    }

    private function testGetSarana()
    {
        dd(VClaim::get_sarana('1001R016'));      
    }

    private function testRujukan()
    {
        dd(VClaim::get_rujukan_by_nomor_kartu_list('0001150413467', true));      
    }

    private function testGetPeserta()
    {
        dd(VClaim::get_peserta_bpjs('0001150413467', date('Y-m-d')));
    }

    private function testGetHistoriPeserta()
    {
        dd(VClaim::histori_pelayanan_peserta('0001305412367', '2019-08-01', '2019-09-20'));
    }

    private function testGetSEP()
    {
        dd(VClaim::get_sep("0903R0050919V000058"));
    }

    private function testDeleteSEP()
    {
        $data = [
            'request' => [
                't_sep' => [
                    'noSep' => "0903R0050819V000002",
                    'user' => 'Coba Ws',
                ]
            ]
        ];

        dd(VClaim::delete_sep($data));
    }

    private function testInsertSEP()
    {
        $data = [
           "request" => [
              "t_sep" => [
                 "noKartu" => "0002048696515",
                 "tglSep" => "2019-08-19",
                 "ppkPelayanan" => "0903R005",
                 "jnsPelayanan" => "1",
                 "klsRawat" => "3",
                 "noMR" => "123456",
                 "rujukan" => [
                    "asalRujukan" => "2",
                    "tglRujukan" => "2019-07-01",
                    "noRujukan" => "1234567",
                    "ppkRujukan" => "0135R025"
                 ],
                 "catatan" => "test",
                 "diagAwal" => "A00.1",
                 "poli" => [
                    "tujuan" => "IGD",
                    "eksekutif" => "0"
                 ],
                 "cob" => [
                    "cob" => "0"
                 ],
                 "katarak" => [
                    "katarak" => "0"
                 ],
                 "jaminan" => [
                    "lakaLantas" => "0",
                    "penjamin" => [
                        "penjamin" => "1",
                        "tglKejadian" => "2018-08-06",
                        "keterangan" => "kll",
                        "suplesi" => [
                            "suplesi" => "0",
                            "noSepSuplesi" => "",
                            "lokasiLaka" => [
                                "kdPropinsi" => "",
                                "kdKabupaten" => "",
                                "kdKecamatan" => ""
                            ]
                        ]
                    ]
                 ],
                 "skdp" => [
                    "noSurat" => "000002",
                    "kodeDPJP" => "208398"
                 ],
                 "noTelp" => "081919999",
                 "user" => "Coba Ws"
              ]
           ]
        ];

        dd(VClaim::insert_sep($data));
    }
}
