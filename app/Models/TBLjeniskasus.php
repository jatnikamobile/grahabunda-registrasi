<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLjeniskasus extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLjeniskasus';
        // Table Primary Key
        $this->primaryKey = 'KDJkasus';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
