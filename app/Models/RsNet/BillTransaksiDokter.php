<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class BillTransaksiDokter extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'BILL_TRDETAILDOKTER';
    protected $primaryKey = 'I_Transaksi';
    public $incrementing = false;
    public $timestamps = false;
}
