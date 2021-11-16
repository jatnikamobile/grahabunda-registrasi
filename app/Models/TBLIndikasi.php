<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLIndikasi extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLIndikasi';
        // Table Primary Key
        $this->primaryKey = 'IndikasiCode';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
