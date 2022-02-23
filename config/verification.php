<?php

function alert($message) {
    echo '<script type="text/javascript">alert("' . $message . '")</script>';
}


function check_email (string $mail) {
    filter_var($mail, FILTER_SANITIZE_EMAIL);
    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return $mail;
    } else {
        header("Refresh:0");
        return alert("Wrong email !");
        exit;
    }
}

function check_password (string $password) {
    $uppercase = preg_match('/[A-Z]/', $password);
    $lowercase = preg_match('/[a-z]/', $password);
    $num = preg_match('/[0-9]/', $password);
    $specialChars = preg_match('/[^\w]/', $password);
    var_dump($uppercase, $lowercase, $num, $specialChars);
    
    if(strlen($password) >= 8 && $num && $uppercase && $lowercase && $specialChars){
        return password_hash($password, PASSWORD_DEFAULT);
    } else {
        alert("Password must contain 8 characters. And must have uppercase, lowercase, numbers and special characters.");
        //header("Refresh:0");
    }
    
}