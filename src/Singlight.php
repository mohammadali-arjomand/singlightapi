<?php

namespace Arjomand\SinglightApi;

class Singlight {
    public static function error(Int $code=403, String $message="") {
        $json = [
            "ok" => false,
            "code" => $code,
            "message" => $message
        ];
        http_response_code($code);
        echo json_encode($json);
        die;
    }
}