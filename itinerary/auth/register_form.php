<?php
session_start();
if (isset($_SESSION["username"])) {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php
    include('../navbar.php');
    ?>
    <section>
        <h1>Formulaire d'inscription</h1>
        <form id="registrationForm" class="auth-form">
            <label for="username">Identifiant</label>
            <input type="text" id="username" name="username" id="username" required maxlength="20">

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" id="password" required>


            <label for="password-confirm">Confirmer</label>
            <input type="password" id="password-confirm" name="password-confirm" id="password-confirm" required>

            <input class="button" type="submit" value="S'inscrire">
        </form>
    </section>

    <script>
        document.getElementById("registrationForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;
            const passwordConfirmation = document.getElementById("password-confirm").value;


            const data = {
                username: username,
                password: password,
                passwordConfirmation: passwordConfirmation
            };

            fetch('../../auth_api/register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(result => {
                    if (result.statut === "Succès") {
                        console.log("Utilisateur enregistré avec succès.");
                    } else {
                        console.error("Erreur lors de l'enregistrement de l'utilisateur:", result.message);
                    }
                })
                .catch(error => {
                    console.error("Erreur lors de la requête:", error);
                });
        });
    </script>
</body>

</html>