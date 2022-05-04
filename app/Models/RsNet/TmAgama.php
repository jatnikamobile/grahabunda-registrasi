<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmAgama extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMAGAMA';
    protected $primaryKey = 'I_Agama';
    public $incrementing = false;
    public $timestamps = false;
}
