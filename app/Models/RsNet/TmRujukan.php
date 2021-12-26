<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmRujukan extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMRUJUKAN';
    protected $primaryKey = 'I_Rujukan';
    public $timestamps = false;
}
