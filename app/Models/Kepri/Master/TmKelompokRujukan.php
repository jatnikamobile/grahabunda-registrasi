<?php

namespace App\Models\Kepri\Master;

use Illuminate\Database\Eloquent\Model;

class TmKelompokRujukan extends Model
{
    function __construct() {
        // Connection used
        $this->connection = 'sqlsrv_kepri';
        // Table Used
        $this->table = 'TMKELOMPOKRUJUKAN';
        // Table Primary Key
        $this->primaryKey = 'I_KelompokRujukan';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }
}
