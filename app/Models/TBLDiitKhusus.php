<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLDiitKhusus extends Model
{
    function DiitKstruct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLDiitKhusus';
        // Table Primary Key
        $this->primaryKey = 'KdDiitK';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

}
