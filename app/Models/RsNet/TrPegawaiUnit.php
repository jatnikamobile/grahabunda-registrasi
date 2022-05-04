<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TrPegawaiUnit extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMPEGAWAI';
    protected $primaryKey = 'C_PEGAWAI';
    public $incrementing = false;
    public $timestamps = false;

    public function unit()
    {
        return $this->belongsTo('App\Models\RsNet\TmUnit', 'I_Unit', 'I_UNIT');
    }
}
