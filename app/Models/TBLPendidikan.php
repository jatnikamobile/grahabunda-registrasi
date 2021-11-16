<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLPendidikan extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLPendidikan';
        // Table Primary Key
        $this->primaryKey = 'KdDidik';
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
            $data->where('NmDidik', 'like', '%'.$q.'%')->orWhere('KdDidik', 'like', '%'.$q.'%');
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
