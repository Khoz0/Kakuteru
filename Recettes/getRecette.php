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

$sql = "SELECT nomRecette FROM liaison WHERE nomIngredient = ";

$listeIng = $_GET['ing'];
$listeIng = explode('[',$listeIng);
print_r($listeIng);
$sql .= "'".$listeIng[1]."'";
$not = 'non';

foreach ($listeIng as $ing) {
    $next = next($listeIng);
    if($next != "" && $not=='non'){
        $sql .= " AND nomRecette IN ( SELECT nomRecette FROM liaison WHERE nomIngredient = '".$next."')";
    }

    if($next != "" && $not=='oui'){
        $sql .= " AND nomRecette NOT IN ( SELECT nomRecette FROM liaison WHERE nomIngredient = '".$next."')";
    }

    if($next == "_"){
        $not = 'oui';
    }
}

$recette = $bdd->prepare($sql);
$recette->execute();
$ingredients = $bdd->prepare("SELECT nomIngredient FROM liaison WHERE nomRecette = :recette");

while ($donnees = $recette->fetch()) {
    echo $donnees['nomRecette']."\n";
    $ingredients->bindParam(":recette", $donnees['nomRecette']);
    $ingredients->execute();
    while($ing = $ingredients->fetch()){
        print_r($ing['nomIngredient']);
        echo "\n";
    }
    echo "_";
}
$recette->closeCursor(); // Termine le traitement de la requête
