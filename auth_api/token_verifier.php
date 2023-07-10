<?php
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_Key = 'secret_key';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        $decoded = JWT::decode($token, new Key($secret_Key, 'HS512'));
        header('Content-Type: application/json');
        echo json_encode(["message" => $decoded]);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(["message" => "jeton inconnu"]);
    }
    ;

} else {
    // Requête invalide
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(["message" => "Requête invalide"]);
}

?>