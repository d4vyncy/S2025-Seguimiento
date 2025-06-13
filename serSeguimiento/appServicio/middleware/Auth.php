<?php

require_once("vendor/firebase/php-jwt/src/JWT.php");
use \firebase\JWT\JWT;

class Auth
{
    private static $secret_key = 'Sdw1s9x8@';
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public static function SignIn($data)
    {
        $time = time();

        $token = array(
            'exp' => $time + (60 * 60),
            'aud' => self::Aud(),
            'data' => $data
        );        
         return JWT::encode($token, self::$secret_key);
    }

    public static function Check($token)
    {
        if (empty($token)) {
            throw new Exception("Invalid token supplied.");
        }

        $decode = JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        );

        if ($decode->aud !== self::Aud()) {
            throw new Exception("Invalid user logged in.");
        }
    }

    public static function GetData($token)
    {
        return JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        )->data;
    }

    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}
//EJEMPLO DE AUTENTICACIÓN
//En nuestro flujo normal una vez validado nuestro usuario y
// password llamamos al método SignIn y le pasamos la 
//información que queremos guardar, en nuestro la información del usuario.
// Luego este nos va a retornar el token asociado.

/*<?php
$usuario  = 'eduardo';
$password = '123456';
if($usuario === if($usuario === 'eduardo' && $password === '123456')
{
    echo Auth::SignIn([
        'id' => 1,
        'name' => 'Eduardo'
    ]);
}*/