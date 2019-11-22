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
	<div id="header" class="container">
		<div id="logo">
			<h1><a href="#">Kakuteru</a></h1>
		</div>
		<div id="menu">
			<ul>
				<li class="active"><a href="#" accesskey="1" title="">Accueil</a></li>
				<li><a href="./nos_cocktails.php" accesskey="2" title="">Nos cocktails</a></li>
				<li><a href="./nos_recettes.php" accesskey="3" title="">Nos recettes</a></li>
				<li><a href="./mon_compte.php" accesskey="4" title="">Mon compte</a></li>
				<li><a href="./a_propos.php" accesskey="5" title="">A propos de nous</a></li>
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
      // On récupère tout le contenu de la table jeux_video
      $recettes = $bdd->query('SELECT * FROM recettes');

      // On affiche chaque entrée une à une
      while ($donnees = $recettes->fetch()){
      $sansEspaces = str_replace(' ', '_', $donnees['nom']);
      $sansAppostrophe = str_replace("'", '', $sansEspaces);
      $nom = str_replace_accent($sansAppostrophe);
      $dirImage = "Projet/Photos/";
      if(is_dir($dirImage)){
        if ($openedDir = opendir($dirImage)) {
          while (($file = readdir($openedDir)) !== false) {
            if(strcasecmp($nom.".jpg", "Mojito.jpg") == 0){

      ?>




    		<div class="boxA"><img src="Projet\Photos\<?php echo $nom.".jpg"?>" height = "200" alt="" /></div>
      <?php break;} ?>
        <?php if(strcasecmp($nom.".jpg", "Sangria_sans_alcool.jpg") == 0){ ?>
    		<div class="boxB"><img src="Projet\Photos\<?php echo $nom.".jpg"?>" height = "200" alt="" /></div>
      <?php break;} ?>
        <?php if(strcasecmp($nom.".jpg", "Bora_bora.jpg") == 0){ ?>
    		<div class="boxC"><img src="Projet\Photos\<?php echo $nom.".jpg"?>" height = "200" alt="" /></div>
        <?php
      break;}
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
