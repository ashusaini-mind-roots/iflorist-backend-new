<?php


namespace App\Helpers;


class Utils
{
    public static function money2Float($currency_amt)
    {
       return floatval(preg_replace('/[^\d\.]/', '', $currency_amt));
    }
    public static function hasRole($role, $rolesArray)
    {
        foreach($rolesArray as $rol){
            if(trim($rol->name) == trim($role))
                return true;
        }
        return false;
    }
    public static function addleftzero($number){
        return str_pad((string)$number, 2, "0", STR_PAD_LEFT);
    }

    public static function random_strings($length_of_string){ 
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
        return substr(str_shuffle($str_result),  
                           0, $length_of_string); 
    } 
}
