<?php
session_start();

if (isset($_SESSION['session_id'])) {
    $session_user = htmlspecialchars($_SESSION['session_user'], ENT_QUOTES, 'UTF-8');
    $session_id = htmlspecialchars($_SESSION['session_id']);
    
    printf("Bienvenue %s, votre ID de session est %s", $session_user, $session_id);
    echo "<br>";
    printf("%s", '<a href="logout.php">Logout</a>');
} else {
    printf("Connectez-vous pour accéder", '<a href="../index.php">Login</a>');
}