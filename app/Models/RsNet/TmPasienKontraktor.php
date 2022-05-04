<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmPasienKontraktor extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMPASIEN_KONTRAKTOR';
    protected $primaryKey = 'I_RekamMedis';
    public $incrementing = false;
    public $timestamps = false;
}
