<?php

namespace App\Models;
use App\Support\Searchable;
use Illuminate\Database\Eloquent\Model;

class TBLKelurahan extends Model
{
    use Searchable;

    protected $searchBy = 'NmKelurahan';
    
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLKelurahan';
        // Table Primary Key
        $this->primaryKey = 'KdKelurahan';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function kecamatan()
    {
        return $this->belongsTo(TBLKecamatan::class, 'KdKecamatan', 'KdKecamatan');
    }
}
