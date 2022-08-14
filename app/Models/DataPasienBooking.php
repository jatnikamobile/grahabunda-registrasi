<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPasienBooking extends Model
{
    protected $connection = 'main';
    protected $table = 'data_pasien_booking';
    protected $primaryKey = 'id';
}
