<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLcarakeluar extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLcarakeluar';
        // Table Primary Key
        $this->primaryKey = 'KDCkeluar';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
