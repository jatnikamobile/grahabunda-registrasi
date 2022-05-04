<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmKodyaKab extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMKODYAKAB';
    protected $primaryKey = 'I_KODYAKAB';
    public $timestamps = false;
}
