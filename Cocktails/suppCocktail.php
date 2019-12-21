<?php
include("../ConnexionBD/index.php");

$tabRequete = explode( "|", $_GET['p']);
$sql = "DELETE FROM Panier WHERE utilisateur = :utilisateur AND nomRecette = :recette";
$stmt = $bdd->prepare($sql);
$stmt->bindParam(":utilisateur", $tabRequete[0]);
$stmt->bindParam(":recette", $tabRequete[1]);
$stmt->execute();
?>