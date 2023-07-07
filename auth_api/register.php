<?php
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
    $passwordConfirmation = $requestData['passwordConfirmation'];

    if (!$username || strlen($username) <= 6 || strlen($username) > 20) {
        return [
            "status" => "error",
            "message" => "username must be longer or shorter (6 to 20 characters)"
        ];
    }
    if (!$password || strlen($password) <= 6) {
        return [
            "status" => "error",
            "message" => "password must be at least 6 characters"
        ];
    }
    if (!$passwordConfirmation || $password !== $passwordConfirmation) {
        return [
            "status" => "error",
            "message" => "passwords must match"
        ];
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, hashedPassword) VALUES(:username, :hashedPassword)");

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":hashedPassword", $hashedPassword);

        $stmt->execute();

        http_response_code(200);
        echo json_encode(array("statut" => "Succès", "message" => "Utilisateur enregistré"));
        exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1062) {
            echo "Username already taken.";
        } else {
            echo "Error registering user: " . $e->getMessage();
        }
    }
}

?>