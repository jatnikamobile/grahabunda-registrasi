<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmPendidikan extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMPENDIDIKAN';
    protected $primaryKey = 'I_Pendidikan';
    public $timestamps = false;
}
