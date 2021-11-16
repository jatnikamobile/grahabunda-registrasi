<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLKelas extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLKelas';
        // Table Primary Key
        $this->primaryKey = 'KDKelas';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
