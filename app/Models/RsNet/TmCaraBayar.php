<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmCaraBayar extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMCARABAYAR';
    protected $primaryKey = 'I_CARABAYAR';
    // public $incrementing = false;
    public $timestamps = false;
}
