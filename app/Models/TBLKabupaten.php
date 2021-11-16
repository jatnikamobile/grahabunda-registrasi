<?php

namespace App\Models;
use App\Models\TBLPropinsi;
use App\Support\Searchable;
use Illuminate\Database\Eloquent\Model;

class TBLKabupaten extends Model
{
    use Searchable;

    protected $searchBy = 'NmKabupaten';

    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLKabupaten';
        // Table Primary Key
        $this->primaryKey = 'KdKabupaten';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function propinsi()
    {
        return $this->belongsTo(TBLPropinsi::class, 'KdPropinsi', 'KdPropinsi');
    }
}
