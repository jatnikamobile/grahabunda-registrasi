<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLkkeluar extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLkkeluar';
        // Table Primary Key
        $this->primaryKey = 'KDKkeluar';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
