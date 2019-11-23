<?php
try
{
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=kakuteru;charset=utf8', 'root', '');
}
catch(Exception $e)
{
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}

$sql = "SELECT nomIngredient FROM ingredients";

$stmt = $bdd->prepare($sql);
$stmt->execute();

while($nom = $stmt->fetch()) {
    echo $nom['nomIngredient']."\n";
}
?>