<?php

namespace Arjomand\SinglightApi;

class Singlight {
    public static function error(Int $code=403, String $message="") {
        http_response_code($code);
        header("Content-type: application/json;charset=UTF-8");
        echo json_encode([
            "ok" => false,
            "code" => $code,
            "message" => $message
        ]);
        die;
    }
    public static function pass($params, $code=200) {
        header("Content-type: application/json;charset=UTF-8");
        if (!isset($params["ok"])) $params["ok"] = true;
        http_response_code($code);
        echo json_encode($params);
    }
    public static function routes() {
        \Monster\App\Route::get("/controllers/{class}/{method}", function ($class, $method) {
            $class = "\\Monster\\App\\Controllers\\" . $class;
            $instance = new $class;
            $instance->$method();
        });
        \Monster\App\Route::get(".*", function () {
            $content = "<h1>404 Not Found</h1>";
            http_response_code(404);
            if (file_exists(__DIR__ . "/../../../../view/index.html"))
                $content = file_get_contents(__DIR__ . "/../../../../view/index.html");
                http_response_code(200);
            $content = preg_replace_callback("/@assets\((.*?)\)/", function ($match) {
                $dir = __DIR__ . "/../../../../view/" . $match[1];
                if (file_exists($dir)) {
                    if (substr($dir, strlen($dir)-3, 3) == "css") $meme = "text/css";
                    else $meme = mime_content_type($dir);
                    return "data:" . $meme . ";base64," . base64_encode(file_get_contents($dir));
                }
                return "";
            }, $content);
            echo $content;
        });
    }
}