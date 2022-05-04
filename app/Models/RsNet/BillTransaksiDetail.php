<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class BillTransaksiDetail extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'BILL_TRANSAKSIDETAIL';
    protected $primaryKey = 'I_TransaksiDetail';
    public $timestamps = false;
}
