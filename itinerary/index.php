<?php

$token = null;
session_start();

if (isset($_SESSION["token"])) {
    $token = $_SESSION["token"];
}
;

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
    if ($method == "POST" && isset($_POST["username"]) && isset($_POST["coordinates"]) && isset($_POST["title"])) {
        $stmt = $pdo->prepare("INSERT INTO itineraries (coordinates,title,username) VALUES (:coord,:title,:username)");
        $result = $stmt->execute(
            array(
                'coord' => filter_input(INPUT_POST, "coordinates"),
                'title' => filter_input(INPUT_POST, "title"),
                'username' => filter_input(INPUT_POST, "username")
            )
        );
    }

    include('navbar.php');
        ?>

    <section>
        <h1>Dashboard</h1>
        <div class='content-container'>
            <?php
            if ($token) {
                list($headersB64, $payloadB64, $sig) = explode('.', $_SESSION["token"]);
                $decoded = json_decode(base64_decode($payloadB64), true);
                $stmt = $pdo->prepare("SELECT * FROM itineraries WHERE username = '" . $decoded["userName"] . "'");
                $stmt->execute();
                $result = $stmt->fetchAll();
                foreach ($result as $itinerary) {
                    $html = "<div class='itinerary-container'>
                <img src='map.png' /><p>" . $itinerary["title"] . "</p>
                </div>";
                    echo $html;
                }
            }
            ?>
        </div>
        <a class='cta' href='./itinerary.php'>Nouvel itinéraire</a>
        <a class='cta' href='./station_list.php'>Liste des stations</a>
    </section>
</body>

</html>