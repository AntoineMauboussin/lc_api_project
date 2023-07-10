<?php

require __DIR__ . '../../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$secret_Key = 'secret_key';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestBody = file_get_contents('php://input');

    if (empty($requestBody)) {
        http_response_code(400);
        echo json_encode(array("statut" => "Erreur", "message" => "JSON incorrect"));
        exit();
    }

    $requestData = json_decode($requestBody, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400);
        echo json_encode(array("statut" => "Erreur", "message" => "JSON incorrect"));
        exit();
    }

    try {
        $token = $requestData['jeton'];
        $decoded = JWT::decode($token, new Key($secret_Key, 'HS512'));
        http_response_code(200);
        echo json_encode(array("statut" => "Succès", "message" => "", "utilisateur" => ["identifiant" => $decoded->userName]));
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Jeton inconnu"));
    }
    ;

} else {
    // Requête invalide
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(["message" => "Requête invalide"]);
}

?>