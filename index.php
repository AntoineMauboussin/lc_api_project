<?php
session_start();
if(!isset($_SESSION["username"]))
{
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenue <?= $_SESSION["username"] ?> !</h1>

    <a href="/auth_api/logout.php">Déconnexion</a>
</body>
</html>