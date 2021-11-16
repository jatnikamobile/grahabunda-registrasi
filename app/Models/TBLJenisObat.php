<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLJenisObat extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLJenisObat';
        // Table Primary Key
        $this->primaryKey = 'JenisCode';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
