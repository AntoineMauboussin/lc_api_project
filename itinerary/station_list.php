<?php
session_start();

if(isset($_SESSION['token'])){
    $token = $_SESSION['token'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
    <link rel="stylesheet" href="style.css">
    <script src="js/station_list.js" defer></script>
</head>
<body>
    <a class='cta' href='./index.php'>Retour</a>
    <div class="list"></div>
    <input class='token' hidden value="<?php echo($token) ?>">
</body>
</html>