<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLcaramasuk extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLcaramasuk';
        // Table Primary Key
        $this->primaryKey = 'KDCmasuk';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
