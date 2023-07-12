<?php
session_start();
if (isset($_SESSION["token"])) {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php
    include('../navbar.php');
    ?>
    <section>
        <h1>Formulaire de connexion</h1>
        <form id="loginForm" class="auth-form">
            <label for="username">Identifiant</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <input class="button" type="submit" value="Se connecter">
        </form>
    </section>
    <script>
        document.getElementById("loginForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            const data = {
                username: username,
                password: password
            };

            fetch('../../auth_api/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(result => {
                    if (result.statut === "Succes") {
                        console.log("Connexion réussie.");
                        window.location.href = "../index.php";
                    } else {
                        console.error("Erreur lors de la connexion:", result.message);
                    }
                })
                .catch(error => {
                    console.error("Erreur lors de la requête:", error);
                });
        });
    </script>
</body>

</html>