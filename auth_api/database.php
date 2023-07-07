<?php

$host = "localhost:3306";
$dbname = "lc_api_project";
$username = "root";
$password = "";

$pdo = new PDO("mysql:host=$host:3306;dbname=$dbname", "$username", "$password");

return $pdo
?>