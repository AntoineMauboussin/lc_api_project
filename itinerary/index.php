<?php

session_start();
if (!isset($_SESSION["token"])) {
    header('Location: /itinerary/auth/login_form.php');
    exit();
}

require_once './token_verifier.php';
// fonction token verifier, on recupère en back le token, on utilise la clé secrete, si on peut accéder a l'identifiant c'est good si non c'est pas good
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <!-- <script src="js/itinerary.js" defer></script> -->
</head>

<body>
    <?php
    $pdo = new PDO('sqlite:' . dirname(__FILE__) . '/database.sqlite');
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    if ($method == "POST") {
        $stmt = $pdo->prepare("INSERT INTO itineraries (coordinates,title) VALUES (:coord,:title)");
        $result = $stmt->execute(
            array(
                'coord' => filter_input(INPUT_POST, "coordinates"),
                'title' => filter_input(INPUT_POST, "title")
            )
        );
    }

    include('navbar.php')
    ?>
    <h1>Dashboard</h1>
    <div class='content-container'>
        <?php
        $stmt = $pdo->prepare("SELECT * FROM itineraries");
        $stmt->execute();
        $result = $stmt->fetchAll();
        foreach ($result as $itinerary) {
            $html = "<div class='itinerary-container'>
            <img src='map.png' /><p>" . $itinerary["title"] . "</p>
            </div>";
            echo $html;
        }
        ?>
    </div>
    <a class='cta' href='./itinerary.php'>Nouvel itinéraire</a>
    <a class='cta' href='./station_list.php'>Liste des stations</a>
</body>

</html>