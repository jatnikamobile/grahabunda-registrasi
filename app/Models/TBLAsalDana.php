<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLAsalDana extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLAsalDana';
        // Table Primary Key
        $this->primaryKey = 'KdDana';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
