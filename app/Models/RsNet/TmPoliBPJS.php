<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmPoliBPJS extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMPOLIBPJS';
    protected $primaryKey = 'I_Unit';
    public $incrementing = false;
    public $timestamps = false;

    public function unit()
    {
        return $this->belongsTo('App\Models\RsNet\TmUnit', 'I_Unit', 'I_Unit');
    }
}
