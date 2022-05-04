<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSPRI extends Model
{
    protected $connection = 'main';
    protected $table = 'pengajuan_spri';
    protected $primaryKey = 'id';
}
