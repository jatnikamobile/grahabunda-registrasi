<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TBLPangkat extends Model
{
    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'TBLPangkat';
        // Table Primary Key
        $this->primaryKey = 'KdPangkat';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = [];
        // 
        $this->hidden = [];
    }

    public static function select2group($angkatan, $q, $limit = 15, $offset=0)
    {
        $data = self::distinct()->select('GroupPangkat')
                    ->offset($offset)
                    ->limit($limit);
        $data->where('Angkatan', $angkatan);
        if($q !== null){
            $data->where('GroupPangkat', 'like', '%'.$q.'%');
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

    public static function select2($angkatan, $group, $q, $limit = 15, $offset=0)
    {
        $data = self::offset($offset)
                      ->limit($limit);
        $data->where('Angkatan', $angkatan);
        $data->where('GroupPangkat', $group);
        if($q !== null){
            $data->where('NmPangkat', 'like', '%'.$q.'%');
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
