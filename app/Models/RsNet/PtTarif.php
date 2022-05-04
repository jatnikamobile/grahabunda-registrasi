<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class PtTarif extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'PT_TARIF';
    protected $primaryKey = 'I_Unit';
    public $timestamps = false;
}
