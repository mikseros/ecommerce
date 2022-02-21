<?php
if(isset($_POST['send'])){
$data = [
    ":titre" => htmlentities($_POST["titre"]),
    ":text" => htmlentities($_POST["text"]),
];

require_once("includes/config.php");

try {
    $dbh = new PDO("mysql:host=$host;dbname=$db", $user, $pw);
    $dbh->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = 'INSERT INTO articles (titre,text) VALUES (:titre,:text)';
   $res = $dbh->prepare($sql);
   
   $exec = $res->execute($data);
   }
   catch (PDOException $exc) {
    echo "Erreur: ". $exc->getMessage()."<br/>" ;
    die(); // OU exit();
   }

   // vérifier si la requête d'insertion a réussi
   if($exec){
    header('Location: dashboard.php');
   }else{
     echo "Échec de l'opération d'insertion";
   }

} 
?>