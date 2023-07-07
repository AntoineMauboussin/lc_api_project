<?php
session_start();
function username()
{
    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
    if($method == "POST")
    {
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");

        // S'il manque des champs, on arrête
        if(!$username || !$password)
        {
            return [
                "status" => "error",
                "message" => "incorrect username or password"
            ];
        }

        // On vérifie que le username existe bien
        $pdo = new PDO("mysql:host=localhost:3306;dbname=lc_api_project", "root", "");
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([
            ":username" => $username
        ]);

        $user = $stmt->fetch();
        // Si l'on n'a trouvé personne dans la BDD
        if(!$user)
        {
            return [
                "status" => "error",
                "message" => "user not found"
            ];
        }

        // Si le mot de passe saisi est incorrect (on vérifie le mot de passe du formulaire)
        // avec le hash venant de la base de données
        if(!password_verify($password, $user["password"]))
        {
            return [
                "status" => "error",
                "message" => "incorrect password"
            ];
        }

        
        // Si on est arrivé là, on peut authentifier la personne
        // C'est toujours bien de supprimer le hash plutôt que le garder en session
        unset($user["password"]);
        // On stocke l'utilisateur dans la session
        $_SESSION["user"] = $user;

        header('Location: index.php');
        exit();
    }
}
$data = username();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <?php if(is_array($data) && $data['status'] == "error"): ?>
        <p style="color: red">
            <?= $data['message'] ?>
        </p>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Identifiant</label>
        <input type="text" name="username" id="username" required maxlength="20">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>