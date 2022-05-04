<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmProvinsi extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMPROPINSI';
    protected $primaryKey = 'I_PROPINSI';
    public $timestamps = false;
}
