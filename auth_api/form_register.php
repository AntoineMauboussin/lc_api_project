<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <form action="register.php" method="GET">
        <label for="username">Identifiant</label>
        <input type="text" name="username" id="username" required maxlength="20">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        
        <label for="password-confirm">Confirmer</label>
        <input type="password" name="password-confirm" id="password-confirm" required>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
