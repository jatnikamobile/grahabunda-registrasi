<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmKontraktor extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMKONTRAKTOR';
    protected $primaryKey = 'I_Kontraktor';
    public $incrementing = false;
    public $timestamps = false;
}
