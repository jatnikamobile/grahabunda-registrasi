<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Radiologi  extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'HeadBilRadAcc';
        // Table Primary Key
        $this->primaryKey = 'NoTran';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function get_list($medrec = '',$nama = '')
    {
        $tgl=date('Y-m-d');
        $data = $this->select(DB::connection('main')->raw("HeadBilRadAcc.NoTran as NoSurat, HeadBilRadAcc.Medrec, CAST( HeadBilRadAcc.Regdate AS DATE ) as TanggalRujukan, HeadBilRadAcc.Regno, HeadBilRadAcc.Firstname, CAST(HeadBilRadAcc.Tanggal as Date) as TanggalSurat,  d.NmTarif, p.NMpoli"))
                    ->join('DetailBilRad as d', 'd.NoTran', "=", "HeadBilRadAcc.NoTran")
                    ->leftJoin("POLItpp as p", "p.KDPoli", "=", "HeadBilRadAcc.KdPoli")
                    ->where("HeadBilRadAcc.Tanda", 0)
                    ->where("d.ACC", 'Y');
        if($medrec != ''){ $data->where("HeadBilRadAcc.Medrec", "like", "%".$medrec."%"); }
        if($nama != ''){ $data->where("HeadBilRadAcc.Firstname", "like", "%".$nama."%"); }
        if ($medrec == '' && $nama == '') {
            $data->where("HeadBilRadAcc.Tanggal",$tgl.' 00:00:00');
        }
        $data = $data->orderBy("HeadBilRadAcc.NoTran","DESC")->orderBy("HeadBilRadAcc.Tanggal","DESC")->paginate(5);
        // dd($data);
        return $data;
    }

    public function find_rujukan($noSurat)
    {
        $data = $this->select(DB::connection('main')->raw("HeadBilRadAcc.*, FtDokter.NmDoc, POLItpp.NMPoli,DetailIrjUtama.KdICD, DetailIrjUtama.Diagnosa "))
                     ->leftJoin("POLItpp", "HeadBilRadAcc.KdPoli", "=", "POLItpp.KDPoli")
                     ->leftJoin("FtDokter", "HeadBilRadAcc.KdDoc", "=", "FtDokter.KdDoc")
                     ->leftJoin("DetailIrjUtama", "HeadBilRadAcc.Regno", "=", "DetailIrjUtama.Regno")
                     ->where("NoTran","like", $noSurat."%"
                 )->first();
        return $data;
    }
    public function UpdateAcc($noSurat)
    {
            DB::connection('main')->table('HeadBilRadAcc')->where('NoTran', $noSurat)->update([
                'Tanda' => 3
            ]);
            // DB::connection('main')->table('DetailBilRad')->where('NoTran', $noSurat)->update([
            //     'ACC' => null
            // ]);
    }
}
