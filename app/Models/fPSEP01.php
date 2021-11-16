<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class fPSEP01 extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'fPSEP01';
        // Table Primary Key
        $this->primaryKey = 'NoPeserta';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function get_data()
    {
    	$data = $this->select(DB::connection('main')->raw("*"))->orderBy("Tanggal","desc")->paginate(15);
        return $data;
    }

    public function get_one($nopeserta)
    {
        $data = $this->select(DB::connection('main')->raw("*"))->where("NoPeserta", $nopeserta)->first();
        return $data;
    }

    public function save_to_fpsep($nopeserta, $firstname, $pelayanan, $keterangan)
    {
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');
        $insert = DB::connection('main')->table('fPSEP01')
                        ->updateOrInsert(
                            ['NoPeserta' => $nopeserta],
                            ['NoPeserta' => $nopeserta,
                            'Tanggal' => date('Y-m-d H:i:s'),
                            'firstname' => $firstname,
                            'Pelayanan' => $pelayanan,
                            'Keterangan' => $keterangan,
                            'Validuser' => $validuser]);
        return $insert;
    }
}
