<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmUnit extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMUNIT';
    protected $primaryKey = 'I_Unit';
    public $incrementing = false;
    public $timestamps = false;

    public function bagian()
    {
        return $this->belongsTo('App\Models\RsNet\TmBagian', 'I_Bagian', 'I_Bagian');
    }

    public function tm_poli_bpjs()
    {
        return $this->belongsTo('App\Models\RsNet\TmPoliBPJS', 'I_Unit', 'I_Unit');
    }
}
