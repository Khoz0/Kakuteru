<?php

include "./Projet/Donnees.inc.php";

define( 'DB_NAME', 'coming_soon' );
$username = 'root';
$pwd = '';
$db = 'Kakuteru';

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
          mdp VARCHAR(16) NOT NULL,
          sexe VARCHAR(1),
          adresse VARCHAR(100),
          postal INT(5),
          ville VARCHAR(100),
          noTelephone INT(10),
          PRIMARY KEY (login)
        );
        
        CREATE TABLE Recette (
          nom VARCHAR(100),
          ingredients VARCHAR(1000),
          preparation VARCHAR(1000),
          PRIMARY KEY (nom)
        );
        
        CREATE TABLE Ingredients (
          nomIngredient VARCHAR(100),
          PRIMARY KEY (nomIngredient)
        );
        
        CREATE TABLE Liaison (
          nomIngredient VARCHAR(100),
          nomRecette VARCHAR(100),
          PRIMARY KEY (nomIngredient, nomRecette),
          CONSTRAINT FK_LiaisonIngredient FOREIGN KEY (nomIngredient) REFERENCES Ingredients(nomIngredient),
          CONSTRAINT FK_LiaisonRecette FOREIGN KEY (nomRecette) REFERENCES Recette(nom)
        );
        
        CREATE TABLE SuperCategorie (
          nom VARCHAR(100),
          nomSuper VARCHAR(100),
          PRIMARY KEY (nom, nomSuper),
          CONSTRAINT FK_SuperCatNom FOREIGN KEY (nom) REFERENCES Ingredients(nomIngredient),
          CONSTRAINT FK_SuperCatNomSuper FOREIGN KEY (nomSuper) REFERENCES Ingredients(nomIngredient)
        )";

/*//////////////////////////////////////////////////////////////////////////////
/       Recette                                                                /
/   nom : Le nom du cocktail                                                   /
/   ingredient : le texte des ingredients                                      /
/   preparation : Le texte de la préparation                                   /
/                                                                              /
/       Ingredients                                                             /
/   nomIngredient : Le nom d'un ingredient (pour chaque ingredient utilisé)    /
/                                                                              /
/       Liaison                                                                /
/   nomIngredient : Le nom d'un ingredient dans une recette                    /
/   nomRecette : Le nom de la recette contenant l'ingredient                   /
/                                                                              /
/       SuperCategorie                                                         /
/   nom : nom d'un ingredient ou d'une catégorie                               /
/   nomSuper : nom de la catégorie englobant cet ingrédient                    /
/                                                                              /
/   par exemple fruit est une catégorie ainsi qu'un ingredient                 /
/   et jus de citron est une catégorie (vide) ainsi qu'un ingredient           /
/                                                                              /
//////////////////////////////////////////////////////////////////////////////*/

try{
  $bdd = new PDO('mysql:host=localhost;charset=utf8', 'root', '');
}catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

foreach (explode(';',$sql) as $requete) {
  $bdd->exec($requete);
}
/*Remplissage de la table Recette*/
$stmt = $bdd->prepare("INSERT INTO Recette (nom, ingredients, preparation) VALUES (:nom, :ingredients, :preparation)");
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':ingredients', $ingredients);
$stmt->bindParam(':preparation', $preparation);

foreach ($Recettes as $titre) {
  $nom = array_values($titre)[0];
  $ingredients = array_values($titre)[1];
  $preparation = array_values($titre)[2];
  $stmt->execute();
}

/*Remplissage de la table Ingredients*/
$stmt = $bdd->prepare("INSERT INTO Ingredients (nomIngredient) VALUES (:nom)");
$stmt->bindParam(':nom', $nom);
foreach ($Hierarchie as $key => $aliment) {
    $nom = $key;
    $stmt->execute();
}

/*Remplissage de la table Liaison*/
$stmt = $bdd->prepare("INSERT INTO Liaison (nomIngredient, nomRecette) VALUES (:nomIng, :nomRec)");
$stmt->bindParam(':nomIng', $nomIng);
$stmt->bindParam(':nomRec', $nomRec);
foreach ($Recettes as $titre){
    $nomRec = array_values($titre)[0];
    foreach ($titre as $key => $value ){
        if(is_array($value)) {
            foreach ($value as $ing){
                $nomIng = $ing;
                $stmt->execute();
            }
        }
    }
}

/*Remplissage de la table SuperCategorie*/
$stmt = $bdd->prepare("INSERT INTO SuperCategorie (nom, nomSuper) VALUES (:nom, :nomSuper)");
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':nomSuper', $nomSuper);
foreach ($Hierarchie as $aliment => $tab){
    if(array_key_exists('super-categorie', $tab)){
        foreach ($tab['super-categorie'] as $super){
            $nom = $aliment;
            $nomSuper = $super;
            $stmt->execute();
        }
    }
}


?>
