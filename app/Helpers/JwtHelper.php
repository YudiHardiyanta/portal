<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    public static function generateToken($secret_metabase, $item_id)
    {
        $payload = [
            "resource" => ["dashboard" => $item_id],
            "params"   => new \stdClass(), // setara dengan {} di JS
            "exp"      => round(microtime(true)) + (10 * 60) // 10 menit dari sekarang
        ];
        


        $token = JWT::encode($payload, $secret_metabase, 'HS256');
        return $token;
    }

    public static function verifyToken($token)
    {
        return JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
    }
}
