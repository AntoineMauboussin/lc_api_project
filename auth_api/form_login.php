<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <form action="login.php" method="POST">
        <label for="username">Identifiant</label>
        <input type="text" name="username" id="username" required maxlength="20">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>