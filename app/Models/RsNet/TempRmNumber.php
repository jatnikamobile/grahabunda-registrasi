<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class TempRmNumber extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'temp_rm_number';
    protected $primaryKey = 'id';
}
