<?php
session_start();

require_once './db.php';

$pdo = new PDO('sqlite:' . dirname(__FILE__) . '/database.sqlite');

require __DIR__ . '../../vendor/autoload.php';

use \Firebase\JWT\JWT;

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

    $username = $requestData['username'];
    $password = $requestData['password'];

    if (!$username || !$password) {
        http_response_code(400);
        echo json_encode(array("statut" => "Erreur", "message" => "Identifiants manquants"));
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['hashedPassword'])) {

            $secret_Key = 'secret_key';
            $request_data = [
                'userName' => $username, // User name
            ];

            $token = JWT::encode(
                $request_data,
                $secret_Key,
                'HS512'
            );

            $_SESSION['token'] = $token;

            http_response_code(200);
            echo json_encode(array("statut" => "Succes", "message" => "Connexion reussie", "jeton" => $token));
            exit();
        } else {
            http_response_code(401);
            echo json_encode(array("statut" => "Erreur", "message" => "Identifiants invalides"));
            exit();
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("statut" => "Erreur", "message" => "Erreur lors de la vérification des identifiants"));
        exit();
    }
}
?>