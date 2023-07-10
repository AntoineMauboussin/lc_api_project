<?php

$loggedIn = isset($_SESSION['token']);

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: logout.php");
    exit();
}
?>

<nav>
    <?php if ($loggedIn): ?>
        <form method="post" action="">
            <input type="hidden" name="logout" value="true">
            <button type="submit">Déconnexion</button>
        </form>
    <?php else: ?>
        <a href="#">Se connecter</a>
        <a href="#">S'inscrire</a>
    <?php endif; ?>
</nav>