<?php

namespace auth;
use \Firebase\JWT\JWT;
class Auth {


    private static $seed = "126k4600";
    private static $encrypt = ['HS256'];
    private static $audit = null;


    public static function TokenGenerate($data){
        $time = time();
        $token = [
            'exp' => $time + (120),
            'aud' => self:: Aud(),
            'data' => $data
        ];
        return JWT::encode($token, self:: $seed);
    }

    public static function GetData($token){
        return JWT::decode($token, self:: $seed, self::$encrypt) -> data;
    }

    private static function Aud(){
        $aud = '';
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

    return $aud;
    }

    public static function tokenvalidate($token){
        try{
        $audit = JWT::decode($token, self::$seed, self::$encrypt) -> aud;
        if($audit === self::Aud()){
//            return "Token valido";
            return true;
        }else{
            return "Token expirado";
        }
        }catch (Exception $e){
//            return "Token no validado";
            return false;
        }
    }


}