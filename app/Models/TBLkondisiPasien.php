<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLkondisiPasien extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLkondisiPasien';
        // Table Primary Key
        $this->primaryKey = 'KDKpasien';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
