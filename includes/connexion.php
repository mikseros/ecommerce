<?php
try {
    $dbh = new PDO("mysql:host=$host;dbname=$db;charset=UTF8", $user, $pw);
    $dbh->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}
catch (PDOException $e){
    echo "ERREUR : ". $e->getMessage()."<br/>" ;
    die("Erreur"); // OU exit();
}
if(isset($dbh)){
    echo "<b>Connexion réussie. </b><br/>";
}else{
    echo "<b>Echec de connexion. </b><br/>";
}
?>