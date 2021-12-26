<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class BillTransaksi extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'BILL_TRANSAKSI';
    protected $primaryKey = 'I_Transaksi';
    public $timestamps = false;
}
