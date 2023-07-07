<?php
$pdo = require __DIR__ . "/database.php";

$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");
$passwordConfirmation = filter_input(INPUT_POST, "password-confirm");

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

$stmt = $pdo->prepare("INSERT INTO users (username, hashedPassword) VALUES(:username, :hashedPassword)");

$stmt->execute([
    ":username" => $username,
    ":hashedPassword" => $hashedPassword
]);

header('Location: login.php');
exit();

?>