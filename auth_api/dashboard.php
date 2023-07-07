<?php
session_start();
if(!isset($_SESSION["user"]))
{
    header('Location: login.php');
    exit();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenue <?= $_SESSION["user"]["login"] ?> !</h1>

    <a href="logout.php">Déconnexion</a>
</body>
</html>