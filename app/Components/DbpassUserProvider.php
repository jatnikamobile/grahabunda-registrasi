<?php

namespace App\Components;

use App\Models\DBpass; 
use Carbon\Carbon;
use Illuminate\Auth\GenericUser; 
use Illuminate\Contracts\Auth\Authenticatable; 
use Illuminate\Contracts\Auth\UserProvider;

class DbpassUserProvider implements UserProvider {

    public function __construct($model)
    {
        $this->model = $model;
    }

    // Proses 1
    public function retrieveByCredentials(array $credentials)
    {
        $query = $this->createModel()->newQuery();

        foreach ($credentials as $key => $value) {
            // if (!contains($key, 'Password')) {
                $query->where($key, $value);
            // }
        }
        return $query->first();
    }
    // Proses 2
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        /* Match password here */
        return $user->Password == $credentials["Password"];
    }
    // Proses 3
    public function retrieveById($identifier)
    {
        /* Get by id */
        return $this->createModel()->newQuery()->find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        echo 'bytoken';
        dd($identifier);
        print_r($token);
        die();
        $model = $this->createModel();

        return $model->newQuery()
            ->where($model->getAuthIdentifierName(), $identifier)
            ->where($model->getRememberTokenName(), $token)
            ->first();
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        echo 'update_token<br>';
        print_r($user);
        print_r($token);
        die();
        $user->setRememberToken($token);
        $user->save();
    }

    public function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');
        return new $class;
    }

    static function contains($haystack, $needle)
    {
        return strpos($haystack, $needle) !== false;
    }
}