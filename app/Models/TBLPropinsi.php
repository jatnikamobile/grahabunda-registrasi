<?php

namespace App\Models;
use App\Support\Searchable;
use Illuminate\Database\Eloquent\Model;

class TBLPropinsi extends Model
{
    use Searchable;

    protected $searchBy = 'NmPropinsi';

    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLPropinsi';
        // Table Primary Key
        $this->primaryKey = 'KdPropinsi';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }
}
