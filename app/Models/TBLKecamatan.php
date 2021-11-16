<?php

namespace App\Models;
use App\Models\TBLKabupaten;
use App\Support\Searchable;
use Illuminate\Database\Eloquent\Model;

class TBLKecamatan extends Model
{
    use Searchable;

    protected $searchBy = 'NmKecamatan';

    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLKecamatan';
        // Table Primary Key
        $this->primaryKey = 'KdKecamatan';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function kabupaten()
    {
        return $this->belongsTo(TBLKabupaten::class, 'KdKabupaten', 'KdKabupaten');
    }
}
