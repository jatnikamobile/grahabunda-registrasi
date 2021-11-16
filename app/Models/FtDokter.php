<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Support\Searchable;
use DB;

class FtDokter extends Model
{
    use Searchable;

    protected $searchBy = ['NmDoc', 'KdDoc'];

    function __construct(){
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'FtDokter';
        // Table Primary Key
        $this->primaryKey = 'KdDoc';
        // Type of Primary Key Table
        $this->keyType = 'string';

        $this->timestamps = false;
        // 
        $this->fillable = ['KdDPJP'];
        // 
        $this->hidden = [];
    }

    public function scopePoli($builder, $kdPoli = null)
    {
        if(!empty($kdPoli))
        {
            $builder->where(function($builder) use ($kdPoli) {
                $builder->orWhere('KdPoli', $kdPoli);
                // $builder->orWhereNull('KdPoli');
                // $builder->orWhere('KdPoli', '');
            });
        }
    }

    public function scopeHasDpjp($builder, $hasDpjp = null)
    {
        if(!empty($hasDpjp))
        {
            $builder->whereNotNull('NoPraktek');
        }
    }

    public function scopeHasSIP($builder, $hasSIP = null)
    {
        if(!empty($hasDpjp))
        {
            $builder->where(function($builder) use ($hasSIP) {
                $builder->whereNotNull('NoPraktek');
                // $builder->orWhereNull('KdPoli');
                // $builder->orWhere('KdPoli', '');
            });
        }
    }

    public static function select2($q, $limit = 15, $offset=0)
    {
        $data = self::offset($offset)
                      ->limit($limit);
        if($q !== null){
            $data->where('NmDoc', 'like', '%'.$q.'%')->orWhere('KdDoc', 'like', '%'.$q.'%');
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

    public function get_data($name)
    {
        $data = $this->select(DB::connection('main')->raw("*"))
            ->where("NmDoc", "like", "%".$name."%")->first();
        return $data;
    }

    public function update_kd_mapping($nama, $kode)
    {
        $data = DB::connection('main')->table('FtDokter')->where('NmDoc', $nama)
            ->update([
                'KdMapping' => $kode,
            ]);
        return $data;
    }

}
