<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLType extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLType';
        // Table Primary Key
        $this->primaryKey = 'KdType';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
