<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLKasusLaka extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLKasusLaka';
        // Table Primary Key
        $this->primaryKey = 'KdKasus';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
