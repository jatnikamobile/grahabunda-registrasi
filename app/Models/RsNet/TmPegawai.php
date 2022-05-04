<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmPegawai extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMPEGAWAI';
    protected $primaryKey = 'C_Pegawai';
    public $incrementing = false;
    public $timestamps = false;

    public function pegawai_unit()
    {
        return $this->belongsTo('App\Models\RsNet\TrPegawaiUnit', 'C_PEGAWAI', 'C_Pegawai');
    }

    public function dokter_unit()
    {
        return $this->hasMany('App\Models\RsNet\TmDokterUnit', 'C_Pegawai', 'C_Pegawai');
    }
}
