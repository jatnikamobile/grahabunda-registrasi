<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLGroupObat extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLGroupObat';
        // Table Primary Key
        $this->primaryKey = 'GroupCode';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
