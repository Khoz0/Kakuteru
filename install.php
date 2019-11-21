<?php

include "./Projet/Donnees.inc.php";

define( 'DB_NAME', 'coming_soon' );
$username = 'root';
$pwd = '';
$db = 'Kaketeru';

// création de la requête sql
// on teste avant si elle existe ou non (par sécurité)
$sql = "DROP DATABASE IF EXISTS $db;
        CREATE DATABASE $db;
        ALTER DATABASE $db DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
        USE $db;
        CREATE TABLE Utilisateur (
          nom VARCHAR(100),
          prenom VARCHAR(100),
          login VARCHAR(100),
          mdp VARCHAR(16),
          sexe VARCHAR(1),
          adresse VARCHAR(100),
          postal INT(5),
          ville VARCHAR(100),
          noTelephone INT(10),
          PRIMARY KEY (login, mdp)
        );
        CREATE TABLE Recette (
          nom VARCHAR(100),
          ingredients VARCHAR(1000),
          preparation VARCHAR(1000),
          PRIMARY KEY (nom)
        );
        CREATE TABLE Ingredient (
          nomIngredient VARCHAR(100),
          PRIMARY KEY (nomIngredient)
        );
        CREATE TABLE Liaison (
          nomIngredient VARCHAR(100),
          nomRecette VARCHAR(100),
          PRIMARY KEY (nomIngredient, nomRecette)
        );
        CREATE TABLE SousCategorie (
          nom VARCHAR(100),
          nomSuper VARCHAR(100),
          PRIMARY KEY (nom, nomSuper)
        )";

/*//////////////////////////////////////////////////////////////////////////////
/       Recette                                                                /
/   nom : Le nom du cocktail                                                   /
/   ingrdient : le texte des ingredients                                       /
/   preparation : Le texte de la préparation                                   /
/                                                                              /
/       Ingredient                                                             /
/   nomIngredient : Le nom d'un ingredient (pour chaque ingredient utilisé)    /
/                                                                              /
/       Liaison                                                                /
/   nomIngredient : Le nom d'un ingredient dans une recette                    /
/   nomRecette : Le nom de la recette contenant l'ingredient                   /
/                                                                              /
/       SousCategorie                                                          /
/   nom : nom d'un ingredient ou d'une catégorie                               /
/   nomSuper : nom de la catégorie englobant cet ingrédient                    /
/                                                                              /
/   par exemple fruit est une catégorie ainsi qu'un ingredient                 /
/   et jus de citron est une catégorie (vide) ainsi qu'un ingredient           /
/                                                                              /
//////////////////////////////////////////////////////////////////////////////*/

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
