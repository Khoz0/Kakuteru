<?php
include("../ConnexionBD/index.php");
ob_start();
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


</head>
<body>
<div id="header-wrapper">
	<div id="header" class="container">
		<div id="logo">
			<h1><a href="../">Kakuteru</a></h1>
		</div>

        <!--Bandeau de navigation-->
		<div id="menu">
			<ul>
				<li class="active"><a href="../" accesskey="1" title="">Accueil</a></li>
				<li><a href="../Cocktails/" accesskey="2" title="">Nos cocktails</a></li>
				<li><a href="../Recettes/" accesskey="3" title="">Nos recettes</a></li>
                <!--On affiche l'onglet mon compte si l'utilisateur est connecté-->
				<?php if (isset($_SESSION['login'])){ ?>
				<li><a href="../Compte/" accesskey="4" title="">Mon compte</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>
<div id="wrapper">
	<div class="title">
		<h2>Connexion au compte<br /></h2>
	</div>
	<div id="page" class="container">
		<div class="boxA">
			<h2>Connexion<br /></h2>
			<p>Les champs comportant le symbole <em>*</em> sont <strong>obligatoire</strong>.</p>
		</div>
		<div class = "boxB">
			<form method="post" action="index.php">
			  <fieldset>
			    <legend>Information du compte</legend>
                  <label for="email">Email <em>*</em></label>
                  <input name="email" type="email" placeholder="Email" required=""
                         pattern="[aA0-zZ9]+[.]?[aA0-zZ9]*@[aA-zZ]*[.]{1}[aA-zZ]+"><br>
                  <label for="mdp">Mot de passe <em>*</em></label>
                  <input type="password" name="mdp" required=""><br>
              <?php

              if (isset($_POST["submit"])) {
                  $mdpVerification='';
                  $verifMail = $bdd->prepare("SELECT mdp FROM Utilisateur where login = :mailVerification");
                  $verifMdp = $bdd->prepare("SELECT login FROM Utilisateur where login = :mailVerification AND mdp = SHA1(:mdpVerification)");
                  $reqMdp = $bdd->prepare("SELECT mdp FROM Utilisateur where login = :mailVerification");
                  $shamdp = $bdd->prepare("SELECT SHA1(:mdp) AS mdp FROM Utilisateur");

                  /*On test si le mail existe dans la base de données*/
                  $mailVerification = $_POST['email'];
                  $verifMail->bindParam(':mailVerification', $mailVerification);
                  $verifMail->execute();

                  if ($donnees = $verifMail->fetch()) {
                      /*Le mail est dans la base de données*/

                      /*On teste si le mot de passe associé  ce mail est celui qui est entré*/
                      $verifMdp->bindParam(':mailVerification', $mailVerification);
                      $verifMdp->bindParam(':mdpVerification', $_POST["mdp"]);
                      $verifMdp->execute();

                      if($donnees = $verifMdp->fetch()){
                          /*Le mot de passe correspond*/
                          session_start();
                          $_SESSION['login'] = $mailVerification;
                          header("Location: ../");
                      }
                      else{
                          /*Le mot de passe ne correspond pas au mail*/
                          echo "<p class='error'>Mot de passe incorrect</p>";
                      }
                  }
                  else{
                      /*Le mail n'est pas dans la base de données*/
                      echo "<p class='error'>Email inconnu</p>";
                  }
              }
              ?>

              </fieldset>
                <p><input name="submit" type="submit" value="Connexion"></p>
            </form>
    </div>
    <div class="boxA">
      <br><br><br>
			<p>Si vous n'êtes pas inscrit <a href="../Inscription/"> cliquez ici </a>.</p>
		</div>
  </div>
</div>
</body>
</html>
