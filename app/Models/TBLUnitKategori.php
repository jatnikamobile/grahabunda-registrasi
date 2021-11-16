<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLUnitKategori extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLUnitKategori';
        // Table Primary Key
        $this->primaryKey = 'KdUnit';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public static function select2($ktg = '', $group = '', $q, $limit = 15, $offset=0)
    {
        $data = self::offset($offset)
                      ->limit($limit);
        if($ktg !== null){
            $data->where('Kategori',$ktg);
        }
        if($group !== null){
            $data->where('GroupKategori',$group);
        }
        if($q !== null){
            $data->where('NmUnit', 'like', '%'.$q.'%');
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

}
