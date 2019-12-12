<?php
include("../ConnexionBD/index.php");
session_start();
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>Kakuteru</title>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
    <link href="../default.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../fonts.css" rel="stylesheet" type="text/css" media="all" />

    <script>
    function ajoutRecette(user, recette){
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
        var str = user+"|"+recette;
        xmlhttp.open("GET","addCocktail.php?p="+str,true);
        xmlhttp.send();
        document.location.href="./";
    }
    </script>

</head>
<body>
<div id="header-wrapper">
  <?php
		if (isset($_SESSION['login'])){
	?>
		<button onclick = "location.href='../Deconnexion/'" class="button" style=vertical-align:middle>Déconnexion</button>
	<?php
	}else{
	?>
		<button onclick="window.location.href = '../ConnexionSite/';" class="button" style=vertical-align:middle>Connexion</button>
	<?php } ?>
    <div id="header" class="container">
        <div id="logo">
           <h1><a href="../">Kakuteru</a></h1>
        </div>
        <div id="menu">
            <ul>
                <li class="active"><a href="../" accesskey="1" title="">Accueil</a></li>
                <li><a href="#" accesskey="2" title="">Nos cocktails</a></li>
                <li><a href="../Recettes/" accesskey="3" title="">Nos recettes</a></li>
        				<?php if (isset($_SESSION['login'])){ ?>
        				<li><a href="../Compte/" accesskey="4" title="">Mon compte</a></li>
        				<?php } ?>
                <li><a href="../A_Propos/a_propos.php" accesskey="5" title="">A propos de nous</a></li>
            </ul>
        </div>
    </div>
</div>
<div id="wrapper">
	<div id="staff" class="container">
    <div class="title">
    <h2>Nos cocktails</h2>
    <span> Voici la liste de nos différents cocktails (disponible dès à présent sur le KakuteruStore)</span> </div>

    <?php

    function str_replace_accent_espace($str)
    {
        $newStr = $str;
        $newStr = preg_replace('#Ç#', 'C', $newStr);
        $newStr = preg_replace('#ç#', 'c', $newStr);
        $newStr = preg_replace('#è|é|ê|ë#', 'e', $newStr);
        $newStr = preg_replace('#È|É|Ê|Ë#', 'E', $newStr);
        $newStr = preg_replace('#à|á|â|ã|ä|å#', 'a', $newStr);
        $newStr = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $newStr);
        $newStr = preg_replace('#ì|í|î|ï#', 'i', $newStr);
        $newStr = preg_replace('#Ì|Í|Î|Ï#', 'I', $newStr);
        $newStr = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $newStr);
        $newStr = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $newStr);
        $newStr = preg_replace('#ù|ú|û|ü#', 'u', $newStr);
        $newStr = preg_replace('#Ù|Ú|Û|Ü#', 'U', $newStr);
        $newStr = preg_replace('#ý|ÿ#', 'y', $newStr);
        $newStr = preg_replace('#Ý#', 'Y', $newStr);
        $newStr = preg_replace('#ń|ǹ|ň|ñ#', 'n', $newStr);
        $newStr = preg_replace('#Ñ|Ń|Ǹ|Ň|ň#', 'N', $newStr);
        $newStr = str_replace(' ', '_', $newStr);
        $newStr = str_replace('.', '', $newStr);
        $newStr = str_replace("'", '', $newStr);

        return ($newStr);
    }
    // On récupère tout le contenu de la table recettes
    $recettes = $bdd->query('SELECT * FROM Recettes');

    // On affiche chaque entrée une à une
    while ($donnees = $recettes->fetch()) {
        ?>
        <div id="page" class="container">
        <div class="boxA">
        <h2><?php echo $donnees['nom']; ?></h2>
        <p><strong>Ingredients : </strong><?php foreach (explode('|', $donnees['ingredients']) as $ing) {
            echo $ing . ", ";
        } ?><br/>
        <strong>Préparation : </strong><?php echo $donnees['preparation'] ?><br/>
        <?php
        $nom = str_replace_accent_espace($donnees['nom']);
        $dirImage = "../Projet/Photos/";
        if (is_dir($dirImage)) {
            if ($openedDir = opendir($dirImage)) {
                while (($file = readdir($openedDir)) !== false) {
                    if (strcasecmp($nom . ".jpg", $file) == 0) {
                        ?><img src="../Projet/Photos/<?php echo $nom . ".jpg" ?>" height="200" alt="" />
                        <?php
                    }
                }
                ?>
                </p>
                </div>
                <div class="boxB">
                <?php
                $nomCocktail = $donnees['nom'];
                $nomCocktailPhoto = $donnees['nom'];
                $nomCocktailPhoto = str_replace_accent_espace($nomCocktailPhoto);
                $recettecocktail = $donnees['ingredients'];
                $recettecocktail = str_replace_accent_espace($recettecocktail);
                $dansPanier = 0;
                if($_SESSION['login']){
                    //Si l'utilisateur est connecté
                    //On regarde toutes les recettes dans son panier
                    $panier = $bdd->prepare("SELECT * FROM Panier WHERE utilisateur = :utilisateur");
                    $panier->bindParam(":utilisateur", $_SESSION['login']);
                    $panier->execute();
                    $dansPanier = 0;
                    while($elementDansPanier = $panier->fetch()){
                        if($elementDansPanier['nomRecette'] == $nomCocktail) {
                            $dansPanier = 1;
                        }
                    }
                    if($dansPanier == 0) {
                        ?>
                            <button class="button" name='<?=$nomCocktail;?>' <?="onclick=\"ajoutRecette('".$_SESSION['login']."', '".$nomCocktail."')\"" ;?>>Ajouter à mes cocktails préférés
                    </button>
                        </div>
                        <?php
                    }
                    else{
                        ?>
                        <form>
                            <button class="button" name="<?= $nomCocktail; ?>">Supprimer de mes cocktails préférés
                            </button>
                        </form>
                    </div>
                    <?php
                    }
                }
            }?>

            </div>
            <?php
        }
    }

    $recettes->closeCursor(); // Termine le traitement de la requête

    ?>
  </div>
  </div>
</body>
</html>
