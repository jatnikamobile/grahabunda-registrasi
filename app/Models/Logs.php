<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    function __construct(){
        // $this->guard = 'dbpass';
        // Connection used
        $this->connection = 'main';
        // Table Used
        $this->table = 'Logs';
        // Table Primary Key
        $this->primaryKey = 'id';
        // Type of Primary Key Table
        // $this->keyType = 'string';
        // 
        $this->fillable = [
            'user_id','ip_address','user_agent','payload','create_at'
        ];
        // 
        $this->hidden = ['ip_address','user_agent'];
    }
}
