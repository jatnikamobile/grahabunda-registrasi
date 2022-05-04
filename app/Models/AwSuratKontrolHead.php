<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AwSuratKontrolHead extends Model
{
    protected $connection = 'main';
    protected $table = 'AwSuratKontrolHead';
    protected $primaryKey = 'NoSurat';
    public $timestamps = false;
}
