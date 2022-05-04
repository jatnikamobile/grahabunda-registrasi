<?php

namespace App\Models\Bridging;

use Illuminate\Database\Eloquent\Model;

class BpjsMonitoringKlaim extends Model
{
    protected $connection = 'sqlsrv_vclaim';
    protected $table = 'bpjs_monitoring_klaim';
    protected $primaryKey = 'NoSep';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}
