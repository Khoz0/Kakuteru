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
			<h1><a href="./kakuteru.php">Kakuteru</a></h1>
		</div>
		<div id="menu">
			<ul>
				<li class="active"><a href="./kakuteru.php" accesskey="1" title="">Accueil</a></li>
				<li><a href="./nos_cocktails.php" accesskey="2" title="">Nos cocktails</a></li>
				<li><a href="./nos_recettes.php" accesskey="3" title="">Nos recettes</a></li>
				<li><a href="#" accesskey="4" title="">Mon compte</a></li>
				<li><a href="./a_propos.php" accesskey="5" title="">A propos de nous</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="wrapper">
	<div class="title">
		<h2>Création du compte<br /></h2>
	</div>
	<div id="page" class="container">
		<div class="boxA">
			<h2>Inscription<br /></h2>
			<p>Les champs comportant le symbole <em>*</em> sont <strong>obligatoire</strong>.</p>
		</div>
		<div class = "boxB">
			<form method="post" action="#">
			  <fieldset>
			    <legend>Information du compte</legend>
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
					// Démarrage ou restauration de la session
				  session_start();
				  // Réinitialisation du tableau de session
				  // On le vide intégralement
				  $_SESSION = array();
				  // Destruction de la session
				  session_destroy();
				  // Destruction du tableau de session
				  unset($_SESSION);
					if (isset($_POST["submit"])){

						$nom = "null";
						$prenom = "null";
						$adresse = "null";
						$postal = 0;
						$ville = "null";
						$telephone = 0;

						$results = $bdd->prepare('SELECT * FROM Utilisateur where login = :mailVerification');
						$mailVerification = $_POST['email'];
						$results->bindParam(':mailVerification', $mailVerification);
						$results->execute();
						if ($donnees = $results->fetch()){?>
							<em> L'adresse mail : <?= $donnees['login'];?> est déjà utilisée</em>
							<br>
						<?php
						}else{
							$email = $_POST["email"];
							$mdp = $_POST["mdp"];
							$sexe = $_POST["sexe"];

							if (!empty($_POST["nom"])){
								$nom = $_POST["nom"];
							}
							if (!empty($_POST["prenom"])){
								$prenom = $_POST["prenom"];
							}
							if(!empty($_POST["adresse"])){
								$adresse = $_POST["adresse"];
							}
							if(!empty($_POST["postal"])){
								$postal = $_POST["postal"];
							}
							if(!empty($_POST["ville"])){
								$ville = $_POST["ville"];
							}
							if(!empty($_POST["telephone"])){
								$telephone = $_POST["telephone"];
							}
							$stmt = $bdd->prepare("INSERT INTO Utilisateur (nom, prenom, login, mdp, sexe, adresse, postal, ville, noTelephone) VALUES (:nom, :prenom, :login, :mdp, :sexe, :adresse, :postal, :ville, :noTelephone)");
							$stmt->bindParam(':nom', $nom);
							$stmt->bindParam(':prenom', $prenom);
							$stmt->bindParam(':login', $email);
							$stmt->bindParam(':mdp', $mdp);
							$stmt->bindParam(':sexe', $sexe);
							$stmt->bindParam(':adresse', $adresse);
							$stmt->bindParam(':postal', $postal);
							$stmt->bindParam(':ville', $ville);
							$stmt->bindParam(':noTelephone', $telephone);
							$stmt->execute();
						}
					}
					?>
					<label for="email">Email <em>*</em></label>
					<input name="email" type="email" placeholder="Email" required="" pattern="[aA0-zZ9]+@[aA-zZ]*[.]{1}[aA-zZ]+"><br>
					<label for="mdp">Mot de passe <em>*</em></label>
					<input name="mdp" required = ""><br>
			  </fieldset>
			  <fieldset>
			    <legend>Information personnelles</legend>
					<label for="nom">Nom</label>
					<input name="nom" placeholder="Nom"><br>
					<label for="prenom">Prenom</label>
					<input name="prenom" placeholder="Prenom"><br>
					<label for="sexe">Sexe</label>
					<select name="sexe">
						<option value="N" name="aucun">Non renseigné</option>
						<option value="F" name="homme">Femme</option>
						<option value="H" name="femme">Homme</option>
					</select><br>
					<label for="naissance">Date de naissance</label>
					<input name="naissance" type="date"><br>
					<label for="adresse">Adresse</label>
					<input name="adresse"><br>
					<label for="postal">Code postal</label>
					<input name="postal" pattern="[0-9]{5}"><br>
					<label for="ville">Ville</label>
					<input name="ville"><br>
					<label for="telephone">Telephone</label>
					<input name="telephone" type="tel" placeholder="0xxxxxxxxx" pattern="0[3, 6, 9, 7, 2][0-9]{8}"><br>
			  </fieldset>
			  <p><input name = "submit" type="submit" value="Créer le compte"></p>
			</form>
		</div>
	</div>
</div>
</body>
</html>
