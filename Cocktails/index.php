<?php
include("../ConnexionBD/index.php");
ob_start();
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
        //Fonction permettant d'ajouter une recette au panier quand l'utilisateur est connecté
    function ajoutRecette(user, recette){
            if (window.XMLHttpRequest) {
                // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {
                // code pour les navigateurs IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
        var str = user+"|"+recette;
            xmlhttp.onreadystatechange = function(){
                if(this.readyState == 4){
                    document.location.href="./";
                }
                else{
                    xmlhttp.send();
                }
            };
        xmlhttp.open("GET","addCocktail.php?p="+str,true);
        xmlhttp.send();
    }

    //Fonction permettant de supprimer une recette du panier quand l'utilisateur est connecté
    function suppRecette(user, recette){
        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        var str = user+"|"+recette;
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4){
                document.location.href="./";
            }
            else{
                xmlhttp.send();
            }
        };
        xmlhttp.open("GET","suppCocktail.php?p="+str,false);
        xmlhttp.send();
    }

    //Fonction permettant d'ajouter une recette au panier quand l'utilisateur n'est pas connecté
    function addCookie(recette) {
        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4){
                document.location.href="./";
            }
            else{
                xmlhttp.send();
            }
        };
        xmlhttp.open("GET","addCookie.php?p="+recette,true);
        xmlhttp.send();
    }


    //Fonction permettant de supprimer une recette du panier quand l'utilisateur n'est pas connecté
    function suppCookie(recette) {
        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4){
                document.location.href="./";
            }
            else{
                xmlhttp.send();
            }
        };
        xmlhttp.open("GET","suppCookie.php?p="+recette,true);
        xmlhttp.send();
    }

    //Fonction qui change la catégorie courante par celle donnée en paramètre et enregistre le chemin parcourue jusque celle ci dans $_SESSION
    function sousCat(superCat) {

        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4){
                document.location.href="./";
            }
            else{
                xmlhttp.send();
            }
        };
        xmlhttp.open("GET","sousCat.php?p="+superCat,true);
        xmlhttp.send();
    }

    function backLead(categorie){

        if (window.XMLHttpRequest) {
            // code pour les navigateurs IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {
            // code pour les navigateurs IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4){
                document.location.href="./";
            }
            else{
                xmlhttp.send();
            }
        };
        xmlhttp.open("GET","backLead.php?p="+categorie,true);
        xmlhttp.send();

    }

    </script>

</head>
<body>
<div id="header-wrapper">
  <?php
        //On affiche le bouton déconnexion si l'utilisateur est connecté
		if (isset($_SESSION['login'])){
	?>
		<button onclick = "location.href='../Deconnexion/'" class="button" style=vertical-align:middle>Déconnexion</button>
	<?php
		}

		//On affiche le bouton connexion si l'utilisateur n'est pas connecté
		else{
	?>
		<button onclick="window.location.href = '../ConnexionSite/';" class="button" style=vertical-align:middle>Connexion</button>
	<?php } ?>

    <!--Bandeau de navigation-->
    <div id="header" class="container">
        <div id="logo">
           <h1><a href="../">Kakuteru</a></h1>
        </div>
        <div id="menu">
            <ul>
                <li class="active"><a href="../" accesskey="1" title="">Accueil</a></li>
                <li><a href="#" accesskey="2" title="">Nos cocktails</a></li>
                <li><a href="../Recettes/" accesskey="3" title="">Nos recettes</a></li>
                        <!--On affiche l'onglet mon compte si l'utilisateur est connecté-->
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
    // Fonction permettant de remplacer les caractère spéciaux, accentués en caractères normaux
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

    function connexion(){
        try
        {
            // On se connecte à MySQL
            $bdd = new PDO('mysql:host=localhost;dbname=kakuteru;charset=utf8', 'root', '');
            return $bdd;
        }
        catch(Exception $e)
        {
            // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : '.$e->getMessage());
        }
    }

    function sousCategorie($categorie){
        $sql = "SELECT nom FROM SuperCategorie WHERE nomSuper = \"".$categorie."\"";
        $bdd = connexion();
        $req = $bdd->query($sql);
        while($donnes = $req->fetch()){
            $sql .= " OR nom IN (".sousCategorie($donnes['nom']).")";
        }
        return $sql;
    }
    ?>

        <h2>Choisissez un filtre pour vos boisson</h2><br>
        <div>
            <?php
            //On affiche toutes les catégories possibles de sélectionner

            //Si c'est le premier chargement la catégorie courante est Aliment
            if(!isset($_SESSION['categorieCourante'])) {
            $_SESSION['categorieCourante'] = 'Aliment';
            $_SESSION['supCategorie']['Aliment'] = 1;
            $superCat = $bdd->query("SELECT DISTINCT nom FROM SuperCategorie WHERE nomSuper = 'Aliment'");
            while ($donnees = $superCat->fetch()) {
                $nomCat = $donnees['nom'];
                $nomCat = str_replace("'", "\'", $nomCat);
                echo "<button class='boutonCat' onclick=\"sousCat('" . $nomCat . "')\">" . $donnees['nom'] . "</button>";
            }
            ?>
        </div><br>
        <?php
        }
            //Sinon on prend la catégorie courante enregistrée
            else{
                if(isset($_SESSION['supCategorie'])){
                    foreach ($_SESSION['supCategorie'] as $cat => $val){
                        if($cat != 'Aliment' && $val==1) {
                            $cat = str_replace("'", "\'", $cat);
                            echo "<button class='boutonCat' onclick=\"backLead('$cat')\">$cat</button><br><br>";
                        }
                    }
                }
                $superCat = $bdd->prepare("SELECT DISTINCT nom FROM SuperCategorie WHERE nomSuper = :super");
                $superCat->bindParam(":super", $_SESSION['categorieCourante']);
                $superCat->execute();
                while ($donnees = $superCat->fetch()) {
                    $nomCat = $donnees['nom'];
                    $nomCat = str_replace("'", "\'", $nomCat);
                    echo "<button class='boutonCat' onclick=\"sousCat('".$nomCat."')\">".$donnees['nom']."</button>";
                }
                ?>
    </div><br>
    <?php
    }

    // On récupère tout le contenu de la table recettes

    $listeRecettes = $bdd->query("SELECT DISTINCT nomRecette FROM Recettes JOIN Liaison ON Liaison.nomRecette = Recettes.nom WHERE nomIngredient IN (".sousCategorie($_SESSION['categorieCourante']).")");
    while($nomRecette = $listeRecettes->fetch()){
        $recettes = $bdd->prepare("SELECT * FROM Recettes WHERE nom = :nom");
        $recettes->bindParam(":nom", $nomRecette['nomRecette']);
        $recettes->execute();

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

                    //Gestion du panier

                    //Si l'utilisateur est connecté
                    if(isset($_SESSION['login'])){

                        //On ajoute les cocktails déjà sélectionnés hors connexion
                        if(isset($_SESSION['panier'])){
                            foreach ($_SESSION['panier'] as $cocktailCookie=>$elem){
                                $panier = $bdd->prepare("INSERT INTO Panier(utilisateur, nomRecette) VALUES (:utilisateur, :recette)");
                                $panier->bindParam(":utilisateur", $_SESSION['login']);
                                $panier->bindParam(":recette", $cocktailCookie);
                                $panier->execute();
                            }
                        }

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
                        //Si la recette en cours est dans son panier
                        if($dansPanier == 0) {
                            ?>
                                <button class="button" name="<?=$nomCocktail;?>" <?="onclick=\"ajoutRecette('".$_SESSION['login']."', '".$nomCocktail."')\"" ;?>>Ajouter à mes cocktails préférés</button>
                            </div>
                            <?php
                        }

                        //Si la recette en cours n'est pas dans son panier
                        else{
                            ?>
                                <button class="button" name="<?= $nomCocktail;?>" <?="onclick=\"suppRecette('".$_SESSION['login']."', '".$nomCocktail."')\"" ;?>>Supprimer de mes cocktails préférés</button>
                        </div>
                        <?php
                        }
                    }

                    //Si l'utilisateur n'est pas connecté
                    else{

                        //Si on a déjà une variable session qui est associée au cocktail en cours
                        if(isset($_SESSION['panier'][$nomCocktail])){

                        //Si il est dans les coktails favoris
                        if($_SESSION['panier'][$nomCocktail] == 1){
                        $nomCocktail = str_replace("'", "\'", $nomCocktail);
                        ?>
                                <button class="button" name="<?=$nomCocktail;?>" <?="onclick=\"suppCookie('$nomCocktail')\""?>>Supprimer de mes cocktails préférés</button>
                            </div>
                            <?php
                            }

                            //Si il n'est pas dans les coktails favoris
                            else{
                            $nomCocktail = str_replace("'", "\'", $nomCocktail);
                            ?>
                                <button class="button" name="<?=$nomCocktail;?>" <?="onclick=\"addCookie('$nomCocktail')\""?>>Ajouter à mes cocktails préférés</button>
                            </div>
                            <?php
                            }

                        }

                        //Si on n'a pas déjà une variable session qui est associée au cocktail en cours
                        else{
                            $nomCocktail = str_replace("'", "\'", $nomCocktail);
                            ?>
                            <button class="button" name="<?=$nomCocktail;?>" <?="onclick=\"addCookie('$nomCocktail')\""?>>Ajouter à mes cocktails préférés</button>
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
                }


                ?>
  </div>
  </div>
</body>
</html>
