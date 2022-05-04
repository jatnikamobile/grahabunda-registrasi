<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanggalPulangBPJS extends Model
{
    protected $connection = 'main';
    protected $table = 'tanggal_pulang_bpjs';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
