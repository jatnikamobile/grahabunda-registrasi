<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLDepo extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLDepo';
        // Table Primary Key
        $this->primaryKey = 'KdDepo';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
