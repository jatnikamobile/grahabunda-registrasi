<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class PtProdukUnit extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'PT_PRODUKUNIT';
    protected $primaryKey = 'I_ProdukUnit';
    public $incrementing = false;
    public $timestamps = false;
}
