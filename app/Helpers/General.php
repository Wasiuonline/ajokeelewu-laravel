<?php

namespace App\Helpers;

class General{

    const BASIC_HEADER = "hskhbdjhdsbfvbfkjvbdskjbkjdsfbv";

    public static function DetToken($det_token)
    {
        if(self::BASIC_HEADER == $det_token){
            return true;
        }
    }

    public static function DetUser($det_token, $user_id)
    {
        if(self::BASIC_HEADER == $det_token && auth()->user()->id == $user_id){
            return true;
        }
    }

}