<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmPasienHubKeluarga extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMPASIEN_HUBKELUARGA';
    protected $primaryKey = 'I_RekamMedis';
    public $incrementing = false;
    public $timestamps = false;
}
