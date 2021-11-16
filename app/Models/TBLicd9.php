<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLicd9 extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLicd9';
        // Table Primary Key
        $this->primaryKey = 'KDICD';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
