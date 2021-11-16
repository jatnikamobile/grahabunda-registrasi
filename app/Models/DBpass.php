<?php

namespace App\Models;

use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class DBpass extends Model implements AuthenticatableContract
{
    use Authenticatable;

    use Notifiable;

    protected $guard;

    function __construct(){
        $this->guard = 'dbpass';
        // Connection used
        $this->connection = 'main';
        // Fild Remember Token For Auth
        $this->rememberTokenName = 'RememberToken';
        // Table Used
        $this->table = 'DBpass';
        // Table Primary Key
        $this->primaryKey = 'NamaUser';
        // Type of Primary Key Table
        $this->keyType = 'string';
        // 
        $this->fillable = [
            'NamaUser', 'Password', 'TRGroup', 'KdPoli',
        ];
        // 
        $this->hidden = [
            'Password', 'TRGroup'
        ];
    }
    //
    // // Table Used
    // protected $table = 'DBpass';
    // public $timestamps = false;
    // // Table Primary Key
    // protected $primaryKey = 'NamaUser';
    // // Type of Primary Key Table
    // protected $keyType = 'string';

    public function change_password($name = '', $oldPassword = '', $newPassword = '', $displayName = '')
    {
        $cek = $this->select(DB::connection('main')->raw("NamaUser, Password"))
            ->where("NamaUser", $name)->where("Password", $oldPassword)->first();
        if (!empty($cek)) {
            $update = DB::connection('main')->table('DBpass')
                ->where('NamaUser', $name)
                ->update([
                    'DisplayName' => strtoupper($displayName),
                    'Password' => strtoupper($newPassword)
                ]);
            $parse = array(
                'status' => true,
                'message' => 'Berhasil mengubah password',
                'update' => $update
            );
        } else {
            $parse = array(
                'status' => false,
                'message' => 'Password dahulu tidak sama',
                'update' => false
            );
        }
        return $parse;
    }
}
