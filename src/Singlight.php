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
    public static function routes() {
        \Monster\App\Route::get("/controllers/{class}/{method}", function ($class, $method) {
            $class = "\\Monster\\App\\Controllers\\" . $class;
            $instance = new $class;
            $instance->$method();
        });
        \Monster\App\Route::get(".*", function () {
            $content = "404 | Not Found";
            if (file_exists(__DIR__ . "/../../../../view/index.html"))
                $content = file_get_contents(__DIR__ . "/../../../../view/index.html");
            echo $content;
        });
    }
}