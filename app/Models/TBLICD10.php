<?php

namespace App\Models;
use DB;
use App\Support\Searchable;
use Illuminate\Database\Eloquent\Model;

class TBLICD10 extends Model
{
    use Searchable;

    protected $searchBy = ['KDICD', 'DIAGNOSA'];

    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLICD10';
        // Table Primary Key
        $this->primaryKey = 'KDICD';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public static function select2($q, $limit = 15, $offset=0)
    {
        $data = self::offset($offset)
                      ->limit($limit);
        if($q !== null){
            $data->where('DIAGNOSA', 'like', '%'.$q.'%')->orWhere('KDICD', 'like', '%'.$q.'%');
        }
        $data = $data->get();
        $has_next = count($data) == (1 + $limit);
        if($has_next) {
            $pop = (array)$data;
            array_pop($pop);
        }
        $send = [
            'data'            => $data,
            'has_next'        => $has_next,
            'has_previous'    => $offset > 0,
            'next_offset'     => $offset + $limit,
            'previous_offset' => $offset - $limit,
        ];
        return $send;
    }

    public static function search_icd($kdicd)
    {
        $data = DB::connection('main')->table('TBLICD10')->where('KDICD', $kdicd)->value('DIAGNOSA');
        // $data = select(DB::connection('main')->raw("DIAGNOSA"))->where("KDICD",$kdicd)->first();
        return $data;
    }

}
