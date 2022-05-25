<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;

class RSA {
    public static function decrypte(){
        if($_SERVER["REQUEST_METHOD"] != "POST") {
            http_response_code(405);
            echo json_encode(["message" => "method not allowed"]);
            return false;
        }

        $body = json_decode(file_get_contents("php://input"), $assoc=true);

        $privkey_file = "privatekey.txt";
        $f = @fopen($privkey_file, "r");
        if(!$f) {
            http_response_code(500);
            echo json_encode(["message" => "Private key doesn't exists"]);
            return false;
        }
        $privkey = fread($f, filesize($privkey_file));
        fclose($f);

        if(!openssl_private_decrypt(base64_decode($body["key"]), $_key, $privkey)) {
            http_response_code(500);
            echo json_encode(["message" => openssl_error_string(), "line" => 24]);
            return false;
        }

        if(!openssl_private_decrypt(base64_decode($body["iv"]), $_iv, $privkey)) {
            http_response_code(500);
            echo json_encode(["message" => openssl_error_string(), "line" => 30]);
            return false;
        }

        if(!($plain = @openssl_decrypt(base64_decode($body["cipher"]), "AES-128-CBC", base64_decode($_key), OPENSSL_RAW_DATA, base64_decode($_iv)))) {
            http_response_code(500);
            echo json_encode(["message" => openssl_error_string(), "line" => 36]);
            return false;
        }

        $data = json_decode($plain, $assoc=true);
        return $data;
    }

}
