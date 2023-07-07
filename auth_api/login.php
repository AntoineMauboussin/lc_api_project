<?php
session_start();

$pdo = require __DIR__ . "/database.php";

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
            $token = bin2hex(random_bytes(16));

            $_SESSION['token'] = $token;
            $_SESSION['username'] = $username;

            http_response_code(200);
            echo json_encode(array("statut" => "Succès", "message" => "Connexion réussie", "jeton" => $token));
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