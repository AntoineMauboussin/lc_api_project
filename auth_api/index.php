<?php
session_start();
header('Content-type: application/json');

var_dump($_SESSION["user"])

/*
try {
    $pdo = new PDO("mysql:host=localhost:3306;dbname=lc_api_project", "root", "");
    $return["status"] = "Success";
    $return["message"] = "Database connected";
} catch(Exception $e) {
    $return["status"] = "Fail";
    $return["message"] = "Can't connect to database";
}

$req = $pdo->prepare("SELECT * FROM users");
$req->execute();

$return = array();
$return["status"] = "Success";
$return["message"] = "everything ok";
$return["results"]["user"] = $req->fetchAll();

echo json_encode($return);
*/

?>