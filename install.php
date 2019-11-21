<?php

define( 'DB_NAME', 'coming_soon' );
$username = 'root';
$pwd = '';
$db = 'Recettes';

// création de la requête sql
// on teste avant si elle existe ou non (par sécurité)
$sql = "DROP DATABASE IF EXISTS $db;
        CREATE DATABASE $db;
        ALTER DATABASE $db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
        USE $db;
        CREATE TABLE Aliment (
          nom VARCHAR(100),
          PRIMARY KEY (nom)
        );
        INSERT INTO Aliment VALUES ('Coco')";


try{
  $bdd = new PDO('mysql:host=localhost;$db;charset=utf8', 'root', '');
}catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

foreach (explode(';',$sql) as $requete) {
  if($requete != ""){
    $bdd->exec($requete);
  }
}

/*$reponse = $bdd->query('SELECT * FROM Boissons');

while ($donnees = $reponse->fetch()){
  echo $donnees['nom'];
}

$reponse->closeCursor();*/

?>
