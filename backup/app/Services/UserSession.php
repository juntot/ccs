<?php

// namespace App\Repository;
namespace App\Services;
use DB;

class UserSession{

    public static function getUserId(){
        return session()->get('auth.userId');
    }

}
