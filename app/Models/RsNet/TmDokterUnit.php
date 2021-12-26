<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmDokterUnit extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMDOKTERUNIT';
    protected $primaryKey = 'I_DokterUnit';
    public $incrementing = false;
    public $timestamps = false;

    public function unit()
    {
        return $this->belongsTo('App\Models\RsNet\TmUnit', 'I_Unit', 'I_Unit');
    }
}
