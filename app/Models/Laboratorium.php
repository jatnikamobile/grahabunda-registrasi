<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Laboratorium  extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'HeadBilLabAcc';
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
        $data = $this->select(DB::connection('main')->raw("HeadBilLabAcc.NoTran as NoSurat, HeadBilLabAcc.Medrec, CAST( HeadBilLabAcc.Regdate AS DATE ) as TanggalRujukan, HeadBilLabAcc.Regno, HeadBilLabAcc.Firstname, CAST(HeadBilLabAcc.Tanggal as Date) as TanggalSurat,  d.NmTarif, p.NMPoli"))
                    ->join('DetailBilLabAcc as d', 'd.NoTran', "=", "HeadBilLabAcc.NoTran")
                    ->leftJoin("POLItpp as p", "p.KDPoli", "=", "HeadBilLabAcc.KdPoli")
                    ->where("HeadBilLabAcc.Tanda", 0)
                    ->where("d.ByUmum", 'Y');
        if($medrec != ''){ $data->where("HeadBilLabAcc.Medrec", "like", "%".$medrec."%"); }
        if($nama != ''){ $data->where("HeadBilLabAcc.Firstname", "like", "%".$nama."%"); }
        if ($medrec == '' && $nama == '') {
            $data->where("HeadBilLabAcc.Tanggal",$tgl.' 00:00:00');
        }
        $data = $data->orderBy("HeadBilLabAcc.NoTran","DESC")->orderBy("HeadBilLabAcc.Tanggal","DESC")->paginate(5);
        // dd($data);
        return $data;
    }

    public function find_rujukan($noSurat)
    {
        $data = $this->select(DB::connection('main')->raw("HeadBilLabAcc.*, FtDokter.NmDoc, POLItpp.NMPoli,DetailIrjUtama.KdICD, DetailIrjUtama.Diagnosa "))
                     ->leftJoin("POLItpp", "HeadBilLabAcc.KdPoli", "=", "POLItpp.KDPoli")
                     ->leftJoin("FtDokter", "HeadBilLabAcc.KdDoc", "=", "FtDokter.KdDoc")
                     ->leftJoin("DetailIrjUtama", "HeadBilLabAcc.Regno", "=", "DetailIrjUtama.Regno")
                     ->where("NoTran","like", $noSurat."%"
                 )->first();
        return $data;
    }

    public function UpdateAcc($noSurat)
    {
            DB::connection('main')->table('HeadBilLabAcc')->where('NoTran', $noSurat)->update([
                'Tanda' => 3
            ]);
            DB::connection('main')->table('DetailBilLabAcc')->where('NoTran', $noSurat)->where('ByUmum', 'Y')->update([
                'ByUmum' => null
            ]);
    }

}
