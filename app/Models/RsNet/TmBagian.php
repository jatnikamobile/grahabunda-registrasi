<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TmBagian extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'TMBAGIAN';
    protected $primaryKey = 'I_Bagian';
    public $incrementing = false;
    public $timestamps = false;
}
