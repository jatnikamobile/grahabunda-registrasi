<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class RujukanBPJS extends Model
{
    protected $dates = ['TglRujukan'];
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'fRujukanBPJS';
        // Table Primary Key
        $this->primaryKey = 'NoSep';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public function get_list($medrec = '', $nama = '', $date1 = '', $date2 = '')
    {
    	$data = $this->select(DB::connection('main')->raw("nosep, tglrujukan, medrec, firstname, norujukan, nopeserta, validuser"));
    	if ($medrec != '') { $data->where('medrec', 'like', '%'.$medrec.'%'); }
        if ($nama != '') { $data->where('firstname', 'like', '%'.$nama.'%'); }
        if ($date1 != '') { $data->where("tglrujukan", ">=", $date1); }
        if ($date2 != '') { $data->where("tglrujukan", "<=", $date2); }
        $data = $data->orderBy("nosep", "desc")->paginate(15);
        return $data;
    }
}
