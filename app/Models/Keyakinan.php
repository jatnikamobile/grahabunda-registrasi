<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Keyakinan extends Model
{
    function __construct() {
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

    public function get_first_pasien($medrec)
    {
    	$data = $this->select(DB::connection('main')->raw("MasterPS.Medrec, MasterPS.Firstname,fKeyakinan.phcek, fKeyakinan.phnote,
    									fKeyakinan.ptcek, fKeyakinan.ptnote, fKeyakinan.pmcek, fKeyakinan.pmnote,
    									fKeyakinan.ppcek, fKeyakinan.ppnote, fKeyakinan.lain, fKeyakinan.tanggal"))
                        ->leftJoin("MasterPS", "fKeyakinan.Medrec", "=", "MasterPS.Medrec")
                        ->where("Medrec",$medrec)->first();
        return $data;
    }

    
}
