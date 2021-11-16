<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class FTracer extends Model
{
    function __construct() {
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'fTracer';
        // Table Primary Key
        $this->primaryKey = 'Regno';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function get_data_tracer($date1 = '')
    {
    	$data = DB::connection('main')->table('fTracer')->select('fTracer.Regno', 'fTracer.Disiapkan', 'fTracer.UserSiap', 'fTracer.Dikeluarkan', 'fTracer.UserKeluar', 'fTracer.Diterima', 'fTracer.UserTerima', 'fTracer.DiPrint', 'fTracer.UserPrint', 'Register.Firstname', 'Register.Medrec', 'POLItpp.NMPoli')
    		->join("Register", "fTracer.Regno", "=", "Register.Regno")
    		->leftJoin("POLItpp", "Register.KdPoli", "=", "POLItpp.KDPoli");
        if ($date1 != '') { $data->where("fTracer.DiPrint", ">=", $date1); }
        if ($date1 != '') { $data->where("fTracer.DiPrint", "<=", date("Y-m-d", strtotime("+1 day", strtotime($date1)))); }
        $data = $data->orderBy("fTracer.DiPrint", "DESC")->paginate(15);
        return $data;
    }

    public function save_to_tbl_tracer($regno)
    {
    	$validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
    	$insert = DB::connection('main')->table('fTracer')
    					->updateOrInsert(
    						['Regno' => $regno],
    						['Regno' => $regno, 'DiPrint' => date('Y-m-d H:i:s'), 'UserPrint' => $validuser]);
    	return $insert;
    }

    public function update_siap($regno)
    {
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');

        $update = DB::connection('main')->table('fTracer')
                        ->where('Regno', $regno)
                        ->update([
                            'Disiapkan' => date('Y-m-d H:i:s'), 
                            'UserSiap' => $validuser
                        ]);
        return $update;
    }

    public function update_keluar($regno)
    {
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');

        $update = DB::connection('main')->table('fTracer')
                        ->where('Regno', $regno)
                        ->update([
                            'Dikeluarkan' => date('Y-m-d H:i:s'), 
                            'UserKeluar' => $validuser
                        ]);
        return $update;
    }

    public function update_terima($regno)
    {
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $update = DB::connection('main')->table('fTracer')
                        ->where('Regno', $regno)
                        ->update([
                            'Diterima' => date('Y-m-d H:i:s'), 
                            'UserTerima' => $validuser
                        ]);
        return $update;
    }

    public function get_one($regno)
    {
    	$data = $this->select(DB::connection('main')->raw("fTracer.Regno, fTracer.Disiapkan, fTracer.UserSiap, fTracer.Dikeluarkan, fTracer.UserKeluar, fTracer.Diterima, fTracer.UserTerima, fTracer.DiPrint, fTracer.UserPrint"))
            ->where("fTracer.Regno", $regno)->first();
        return $data;
    }
}
