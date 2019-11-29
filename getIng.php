<?php

include("../Connexion/connexion.php");

$ing = $_GET['ing'];
$sql = "SELECT nomIngredient FROM ingredients WHERE nomIngredient LIKE '".$ing."%'";

$stmt = $bdd->prepare($sql);
$stmt->execute();

while($nom = $stmt->fetch()) {
    echo $nom['nomIngredient']."\n";
}
?>
