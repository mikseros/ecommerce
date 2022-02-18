<?php
require_once("includes/config.php");
include("includes/connexion.php");


if (isset($_POST['register'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $isEmailValid = filter_var(
        $email,
        FILTER_VALIDATE_REGEXP, [
            "options" => [
                "regexp" => "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/"
            ]
        ]
    );
    $pwdLenght = mb_strlen($password);
    
    if (empty($email) || empty($password)) {
        $msg = 'Remplir tous les champs %s';
    } elseif (false === $isEmailValid) {
        $msg = "L'email n’est pas valide.";
    } elseif ($pwdLenght < 8 || $pwdLenght > 20) {
        $msg = 'Longueur minimale de mot de passe 8 caractères.
        Longueur maximale 20 caractères';
    } else {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $query = "
            SELECT id
            FROM users
            WHERE email = :email
        ";
        
        $check = $dbh->prepare($query);
        $check->bindParam(':email', $email, PDO::PARAM_STR);
        $check->execute();
        
        $user = $check->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($user) > 0) {
            $msg = 'Email déjà présent %s';
        } else {
            $query = "
                INSERT INTO users
                VALUES (:email, :password)
            ";
        
            $check = $dbh->prepare($query);
            $check->bindParam(':email', $email, PDO::PARAM_STR);
            $check->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $check->execute();
            
            if ($check->rowCount() > 0) {
                $msg = 'Enregistrement effectué avec succès';
            } else {
                $msg = 'Erreur %s';
            }
        }
    }
    
    printf($msg, '<a href="../index.php">Revenir en arrière</a>');
}