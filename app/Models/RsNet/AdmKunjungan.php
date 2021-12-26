<?php

namespace App\Models\RsNet;

use Illuminate\Database\Eloquent\Model;

class AdmKunjungan extends Model
{

    protected $connection = 'sqlsrv_kepri';
    protected $table = 'ADM_KUNJUNGAN';
    protected $primaryKey = 'I_Kunjungan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function generateCode($unit, $tanggal = null)
    {
        $date = $tanggal ? date('dmy', strtotime($tanggal)) : date('dmy');

        $last_record = $this->on('sqlsrv_kepri')->where('I_Kunjungan', 'like', $date . '-' . sprintf('%04d', $unit) . '%')->orderBy('I_Kunjungan', 'desc')->first();
        if ($last_record) {
            $code = $last_record->I_Kunjungan;
            $arr_code = explode('-', $code);
            $next_code = isset($arr_code[2]) ? $date . '-' . sprintf('%04d', $unit) . '-' . (sprintf('%05d', ($arr_code[2] + 1))) : $date . '-' . sprintf('%04d', $unit) . '-00001';
        } else {
            $next_code = $date . '-' . sprintf('%04d', $unit) . '-00001';
        }

        return $next_code;
    }
}
