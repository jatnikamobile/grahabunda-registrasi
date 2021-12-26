<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmKelurahan extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMKELURAHAN';
    protected $primaryKey = 'I_KELURAHAN';
    public $timestamps = false;
}
