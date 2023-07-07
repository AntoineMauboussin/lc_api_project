<?php
// On démarre la session
session_start();
// On détruit la session
session_destroy();
// On redirige vers la page de connexion
header('Location: ../index.php');
exit();