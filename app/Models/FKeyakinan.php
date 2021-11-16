<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class FKeyakinan extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'fKeyakinan';
        // Table Primary Key
        $this->primaryKey = 'Medrec';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function get_keyakinan($medrec)
    {
    	$data = $this->select(DB::connection('main')->raw("fKeyakinan.Medrec, fKeyakinan.phcek, fKeyakinan.phnote, fKeyakinan.ptcek, fKeyakinan.ptnote, fKeyakinan.pmcek, fKeyakinan.pmnote, fKeyakinan.ppcek, fKeyakinan.ppnote, fKeyakinan.lain, fKeyakinan.Validuser, fKeyakinan.tanggal, MasterPS.Firstname"))
        ->leftJoin("MasterPS", "fKeyakinan.Medrec", "=", "MasterPS.Medrec")
        ->where("fKeyakinan.Medrec", $medrec)->orderBy("fKeyakinan.tanggal","desc")->first();
        return $data;
    }
}
