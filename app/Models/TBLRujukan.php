<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLRujukan extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLRujukan';
        // Table Primary Key
        $this->primaryKey = 'KDRujukan';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
