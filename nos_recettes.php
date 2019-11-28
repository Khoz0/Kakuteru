<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>Kakuteru</title>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
    <link href="default.css" rel="stylesheet" type="text/css" media="all" />
    <link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
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

    function str_replace_cocktail($str)
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
        $newStr = str_replace(' ', '_', $newStr);
        $newStr = str_replace("'", '', $newStr);

        return ($newStr);
    }
    ?>

    <script>
        function suggestion(str) {
            const listSugg = document.getElementById("suggestion");
            if (str == "") {
                var opts = select.getElementsByTagName('option');
                for(var i = 0; i < opts.length; ){
                    listSugg.removeChild(opts[i]);
                }
                return;
            }
            else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    var optionListe='';
                    var liste = this.responseText.split("\n");
                    for (var i=0; i < liste.length;++i){
                        optionListe += "<option value=\""+liste[i]+"\" />\n"; // Storing options in variable
                    }
                    listSugg.innerHTML = optionListe;
                };
                xmlhttp.open("GET","getIng.php?ing="+str,true);
                xmlhttp.send();

            }
        }
    </script>


</head>
<body>
<div id="header-wrapper">
    <div id="header" class="container">
        <div id="logo">
            <h1><a href="./kakuteru.php">Kakuteru</a></h1>
        </div>
        <div id="menu">
            <ul>
                <li class="active"><a href="./kakuteru.php" accesskey="1" title="">Accueil</a></li>
                <li><a href="./nos_cocktails.php" accesskey="2" title="">Nos cocktails</a></li>
                <li><a href="#" accesskey="3" title="">Nos recettes</a></li>
                <li><a href="./mon_compte.php" accesskey="4" title="">Mon compte</a></li>
                <li><a href="./a_propos.php" accesskey="5" title="">A propos de nous</a></li>
            </ul>
        </div>
    </div>
</div>
<div id="wrapper">
    <h2> FUTUR TRUC JASON DEROULANT (elle était pas ouf j'avoue)</h2>
    <form method="post" action="#">
        <input name="entreeUser" type="text" list="suggestion" required="required" autocomplete="off" onkeyup="suggestion(this.value)"/>
        <datalist id="suggestion">
        </datalist>
        <input type="submit" name="Valider" value="Valider" />
    </form>


    <?php
    if(isset($_POST['Valider'])) {
        if (isset($_POST['entreeUser'])){
            $recette = $bdd->prepare("SELECT nomRecette FROM liaison WHERE nomIngredient = :ing");
            $ing = $_POST['entreeUser'];
            $recette->bindParam(':ing', $ing);
            $recette->execute();
            $ingredients = $bdd->prepare("SELECT nomIngredient FROM liaison WHERE nomRecette = :recette")
            ?>
            <p>
            <?php while ($donnees = $recette->fetch()) { ?>
                    <br><br><strong>Recette</strong> : <?= $donnees['nomRecette']; ?>
                    <br/>
                    Ingredients :<?php
                    $ingredients->bindParam(":recette", $donnees['nomRecette']);
                    $ingredients->execute();
                    while ($ing = $ingredients->fetch()) {
                        echo $ing['nomIngredient'];
                        echo ", ";
                    }
                echo "</p>";
                }
            }

            $recette->closeCursor(); // Termine le traitement de la requête
        }
    ?>
</div>
</body>
</html>
