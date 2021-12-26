<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmGolonganDarah extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMGOLONGANDARAH';
    protected $primaryKey = 'I_GolonganDarah';
    public $incrementing = false;
    public $timestamps = false;
}
