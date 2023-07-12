<?php
$token = null;

if(isset($_SESSION['token'])){
    $token = $_SESSION['token'];
};

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
};
?>

<nav>
    <?php if ($token): ?>
        <form id="logoutform" method="post" action="">
            <input id="logout" type="hidden" name="logout" value="true">
            <button class="button" type="submit">Déconnexion</button>
        </form>
    <?php else: ?>
        <a href="/itinerary/auth/login_form.php">Se connecter</a>
        <a href="/itinerary/auth/register_form.php">S'inscrire</a>
    <?php endif; ?>
</nav>
