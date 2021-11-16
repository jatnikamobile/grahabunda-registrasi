<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TblKategori extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TblKategori';
        // Table Primary Key
        $this->primaryKey = 'Kode';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
