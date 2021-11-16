<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLJangkaWaktu extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLJangkaWaktu';
        // Table Primary Key
        $this->primaryKey = 'Keterangan';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
