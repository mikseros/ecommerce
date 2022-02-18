<?php
session_start();
require_once("includes/config.php");
include("includes/connexion.php");

if (isset($_SESSION['session_id'])) {
    header('Location: dashboard.php');
    exit;
}

if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $msg = "Saisissez l'email' et le mot de passe %s";
    } else {
        $query = "
            SELECT email, password
            FROM users
            WHERE username = :username
        ";
        
        $check = $dbh->prepare($query);
        $check->bindParam(':email', $email, PDO::PARAM_STR);
        $check->execute();
        
        $user = $check->fetch(PDO::FETCH_ASSOC);
        
        if (!$user || password_verify($password, $user['password']) === false) {
            $msg = 'e-mail ou mot de passe incorrect %s';
        } else {
            session_regenerate_id();
            $_SESSION['session_id'] = session_id();
            $_SESSION['session_user'] = $user['email'];
            
            header('Location: dashboard.php');
            exit;
        }
    }
    
    printf($msg, '<a href="../index.php">Revenir en arrière</a>');
}