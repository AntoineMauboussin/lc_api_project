<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <script src="js/itinerary.js" defer></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
</head>
<body>
    <a class='cta' href='./index.php'>Retour</a>
    <div id="map"></div>
    <form method="POST" action="./index.php">
        <input name='coordinates' class='coordinates' type='text' hidden required/>
        <label for='title'>Nom de l'itinéraire :</label>
        <input name='title' type='text'required/>
        <button>Enregistrer l'itinéraire</button>
    </form>
</body>
</html>