<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLDiit extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLDiit';
        // Table Primary Key
        $this->primaryKey = 'KdDiit';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
