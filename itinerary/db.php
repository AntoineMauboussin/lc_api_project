<?php
try{
    $pdo = new PDO('sqlite:'.dirname(__FILE__).'/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT

    $pdo->query("CREATE TABLE IF NOT EXISTS itineraries ( 
        id            INTEGER         PRIMARY KEY AUTOINCREMENT,
        coordinates         TEXT,
        title         TEXT,
        username        TEXT
    );");
} catch(Exception $e) {
    echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
    die();
}


?>