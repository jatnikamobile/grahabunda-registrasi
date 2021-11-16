<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLSex extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLSex';
        // Table Primary Key
        $this->primaryKey = 'KdSex';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
