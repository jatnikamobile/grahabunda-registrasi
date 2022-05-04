<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class PTProductDefault extends Model
{
    protected $connection = 'sqlsrv_kepri';
    protected $table = 'PT_PRODUKDEFAULT';
    protected $primaryKey = 'I_Unit';
    public $timestamps = false;

    public function ptTarif()
    {
        return $this->hasOne('App\Models\RsNet\PtTarif', 'I_ProdukUnit', 'I_Produk');
    }
}
