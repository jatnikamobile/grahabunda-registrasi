<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLPrincipal extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLPrincipal';
        // Table Primary Key
        $this->primaryKey = 'KdPrincipal';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
