<?php

include("../ConnexionBD/index.php");

$ing = $_GET['ing'];
$sql = "SELECT DISTINCT nomIngredient FROM Liaison WHERE nomIngredient LIKE '".$ing."%'";

$stmt = $bdd->prepare($sql);
$stmt->execute();

while($nom = $stmt->fetch()) {
    echo $nom['nomIngredient']."\n";
}
?>
