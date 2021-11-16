<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLKategoriObat extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLKategoriObat';
        // Table Primary Key
        $this->primaryKey = 'KdKateogri';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
