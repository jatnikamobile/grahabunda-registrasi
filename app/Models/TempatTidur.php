<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class TempatTidur extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'Detailttidur';
        // Table Primary Key
        $this->primaryKey = 'ttcode';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function search_ttidur($kode)
    {
    	$data = $this->select(DB::connection('main')->raw("*"))->where("ttcode", "=", $kode)->first();
        
        return $data;
    }
}
