<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmKecamatan extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMKECAMATAN';
    protected $primaryKey = 'I_KECAMATAN';
    public $timestamps = false;
}
