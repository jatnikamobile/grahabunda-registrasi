<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLJenisBayar extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLJenisBayar';
        // Table Primary Key
        $this->primaryKey = 'KDJbayar';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
