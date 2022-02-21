<?php
session_start();

if (isset($_SESSION['session_id'])) {
    $session_user = htmlspecialchars($_SESSION['session_user'], ENT_QUOTES, 'UTF-8');
    $session_id = htmlspecialchars($_SESSION['session_id']);
    
    printf("%s", '<a href="logout.php">Logout</a>');
} else {
    printf("Connectez-vous pour accéder", '<a href="index.php">Login</a>');
}
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
<title>Table des articles + Formoulaire pour ajouter les articles</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="Table des articles + Formoulaire pour ajouter les articles">
<meta name="Robots" content="index, follow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="css/style2.css" rel="stylesheet" type="text/css">
</head>
<body>  
<div id="wrapper">

<div id="tab">
<h3>Table des articles</h3> 
<table>
<thead>
  <tr>
	<th>ID</th>
	<th>Titre</th>
	<th>Text</th>
  </tr>
</thead>
<tbody>
      <?php 
      require_once("includes/config.php");

      // récupérer tous les livres
      $article = "SELECT * FROM articles";
      
      try {
          $dbh = new PDO("mysql:host=$host;dbname=$db", $user, $pw);
          $dbh->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
          $stmt = $dbh->query($article);
          $stmt->setFetchMode(PDO::FETCH_ASSOC) ;

         if($stmt === false){
          die("Erreur"); //OU exit();
         }
        }
      catch (PDOException $exc){
          echo $exc->getMessage();
        }
      if (!empty($stmt))
          foreach ($stmt as $ligne): // i 2 punti dopo la parentesi sono corretti
      ?>
    <tr>
        <td><?php echo htmlentities($ligne['id']);?></td>
        <td><?php echo htmlentities($ligne['titre']);?></td>
        <td><?php echo htmlentities($ligne['text']);?></td>
    </tr>
      <?php endforeach; ?>
      </tbody>
</table>
</div>

<div id="fde">
   <h3>Formulaire d'enregistrement articles</h3>
    <form action="savedata.php" method="post" name="form" id="form">
      
      <label for=titre>Titre</label>
      <input name="titre" id="titre" type=text placeholder="titre"  class="camp">
      
      <label for="avis_biblio">Text</label>
      <textarea name="text" id="text" rows="15" cols="50" placeholder="text" class="camp"></textarea>
      
      <input type="submit" name="send" id="action" value="Enregistrer">
      
      <input type="reset" name="reset" id="reset" value="Reset">

    </form>
</div>

</div>
</body>
</html>