<!DOCTYPE html>
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
if (isset($_POST["submit"])){
  $results = $bdd->prepare('SELECT mdp FROM Utilisateur where login = :mailVerification');
  $mailVerification = $_POST['email'];
  $results->bindParam(':mailVerification', $mailVerification);
  $results->execute();
  if ($donnees = $results->fetch()){
     $mdp = $donnees['mdp'];
   }
   if ($mdp == $_POST["mdp"]){
     $_SESSION['mailVerification'] = $mailVerification;
   }
}
  session_start();
  if(isset($_SESSION['mailVerification'])){
    echo "AAAAAAAAAAAAAAAAAAAAA";
    header("Location : ./kakuteru.php");
  }
  else{
    echo "BBBBBBBBBBBBBBBBBBBB";
  }
?>
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
			<h1><a href="./kakuteru.php">Kakuteru</a></h1>
		</div>
		<div id="menu">
			<ul>
				<li class="active"><a href="./kakuteru.php" accesskey="1" title="">Accueil</a></li>
				<li><a href="./nos_cocktails.php" accesskey="2" title="">Nos cocktails</a></li>
				<li><a href="./nos_recettes.php" accesskey="3" title="">Nos recettes</a></li>
				<li><a href="./mon_compte.php" accesskey="4" title="">Mon compte</a></li>
				<li><a href="./a_propos.php" accesskey="5" title="">A propos de nous</a></li>
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
			<form method="post" action="./connexion.php">
			  <fieldset>
			    <legend>Information du compte</legend>
          <?php
          ?>
          <label for="email">Email <em>*</em></label>
					<input name="email" type="email" placeholder="Email" required="" pattern="[aA0-zZ9]+@[aA-zZ]*[.]{1}[aA-zZ]+"><br>
					<label for="mdp">Mot de passe <em>*</em></label>
					<input name="mdp" required = ""><br>
			  </fieldset>
			  <p><input name = "submit" type="submit" value="Connexion"></p>
      </form>
    </div>
    <div class="boxA">
      <br><br><br>
			<p>Si vous n'êtes pas inscrit <a href="inscription.php"> cliquez ici </a>.</p>
		</div>
  </div>
</div>
</body>
</html>
