<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class TBLInformasi extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLInformasi';
        // Table Primary Key
        $this->primaryKey = 'id';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function informasi_now($date = '')
    {
        $informasi = $data = $this->select(DB::connection('main')->raw("Informasi, Tanggal, ValidUser"))
        ->where("Tanggal", $date)->get();
        return $data;
    }

    public function post_informasi($keterangan = '', $date = '')
    {
        $validuser = Auth::user()->NamaUser.' '.date('d/m/Y H:i:s');

        $input = DB::table('TBLInformasi')->insert(
            ['Informasi' => $keterangan, 'Tanggal' => $date, 'ValidUser' => $validuser]
        );
        return $input;
    }

}
