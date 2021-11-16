<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLSatuan extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLSatuan';
        // Table Primary Key
        $this->primaryKey = 'STCode';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
