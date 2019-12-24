<?php
include("./ConnexionBD/index.php");
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
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />


</head>
<body>
<div id="header-wrapper">
	<?php
    //On affiche le bouton déconnexion si l'utilisateur est connecté
    if (isset($_SESSION['login'])){
	?>
		<button onclick = "location.href='Deconnexion/'" class="button" style=vertical-align:middle>Déconnexion</button>
	<?php
	}
    //On affiche le bouton connexion si l'utilisateur n'est pas connecté
    else{
	?>
		<button onclick="window.location.href = 'ConnexionSite/';" class="button" style=vertical-align:middle>Connexion</button>
	<?php } ?>
	<div id="header" class="container">
		<div id="logo">
			<h1><a href="#">Kakuteru</a></h1>
		</div>
		<div id="menu">
			<ul>
				<li class="active"><a href="#" accesskey="1" title="">Accueil</a></li>
				<li><a href="Cocktails/" accesskey="2" title="">Nos cocktails</a></li>
				<li><a href="Recettes/" accesskey="3" title="">Nos recettes</a></li>
                <!--On affiche l'onglet mon compte si l'utilisateur est connecté-->
				<?php if (isset($_SESSION['login'])){ ?>
				<li><a href="Compte/" accesskey="4" title="">Mon compte</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>
<div id="wrapper">
	<div id="staff" class="container">
		<div class="title">
			<h2>Quelques cocktails</h2>
			<span>Voici une présentation de nos cocktails les plus populaires (classement basé sur on s'en fout c'est mon site)</span> </div>

      <?php
      function str_replace_accent($str)
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

          return ($newStr);
      }

      function str_sansEspace_sansAppostrophe_sansAccent($str){
          $sansEspaces = str_replace(' ', '_', $str);
          $sansAppostrophe = str_replace("'", '', $sansEspaces);
          return str_replace_accent($sansAppostrophe);
      }
      // On récupère tout le contenu de la table jeux_video
      $recettes = $bdd->query('SELECT * FROM Recettes');
      $mojito = $bdd->query("SELECT * FROM Recettes WHERE nom='Mojito'");
      $sangriaSA = $bdd->query("SELECT * FROM Recettes WHERE nom='Sangria sans alcool'");
      $bora = $bdd->query("SELECT * FROM Recettes WHERE nom='Bora bora'");
      $dirImage = "Projet/Photos/";
      if(is_dir($dirImage)){
          if ($openedDir = opendir($dirImage)) {
              /*On récupère le résultat des requêtes*/
              if ($donnees = $mojito->fetch()) {
                  $nomMojito = str_sansEspace_sansAppostrophe_sansAccent($donnees['nom']);
              }
              if ($donnees = $sangriaSA->fetch()) {
                  $nomSangria = str_sansEspace_sansAppostrophe_sansAccent($donnees['nom']);
              }
              if ($donnees = $bora->fetch()){
                  $nomBora = str_sansEspace_sansAppostrophe_sansAccent($donnees['nom']);
              }

              /*Pour chaque image du dossier on regarde si on a une correspondance*/
              while (($file = readdir($openedDir)) !== false) {
                  if(strcasecmp($nomMojito.'.jpg', $file) == 0){ ?>
                      <div class="boxA"><img src="<?= $dirImage.$file?>" height = "200" alt=""/></div>
                  <?php
                  }
                  if(strcasecmp($nomSangria.'.jpg', $file) == 0){ ?>
                    <div class="boxB"><img src="<?= $dirImage.$file?>" height = "200" alt=""/></div>
                <?php
                  }
                  if (strcasecmp($nomBora. '.jpg', $file) == 0) { ?>
                    <div class="boxC"><img src="<?= $dirImage . $file ?>" height="200" alt=""/></div>
                    <?php
                  }
              }
          }
      }
?>
	</div>
	<div id="page" class="container">
		<div class="boxA">
			<h2>Le mojito<br /></h2>
			<p>Ca se prononce morito pas mo j to.</p>
		</div>
		<div class="boxB">
			<h2>La sangria sans alcool<br /></h2>
				<p>Sans alcool, la fête est plus folle!</p>
		</div>
		<div class="boxC">
			<h2>Le bora bora<br /></h2>
				<p>Bora-Bora est une petite île du Pacifique sud, située au nord-ouest de Tahiti, en Polynésie française. Entourée d'îlots de sable, appelés "motus", et d'une eau turquoise protégée par un récif corallien, l'île est un haut lieu de la plongée sous-marine. C'est également une destination touristique prisée pour ses complexes de luxe, dont certains proposent des bungalows sur pilotis. Au centre de l'île s'élève le mont Otemanu, un volcan endormi culminant à 727 m.</p>
		</div>
	</div>
</div>
<div id="welcome-wrapper">
	<div id="welcome" class="container">
		<div class="title">
			<h2>Welcome to our website</h2>
		</div>
		<p>This is <strong>OpenSpace</strong>, a free, fully standards-compliant CSS template designed by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>. The photos in this template are from <a href="http://fotogrph.com/"> Fotogrph</a>. This free template is released under the <a href="http://templated.co/license">Creative Commons Attribution</a> license, so you're pretty much free to do whatever you want with it (even use it commercially) provided you give us credit for it. Have fun :) </p>
	</div>
</div>
<div id="copyright" class="container">
	<p>&copy; Untitled. All rights reserved. | Photos by <a href="http://fotogrph.com/">Fotogrph</a> | Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
</div>
</body>
</html>
