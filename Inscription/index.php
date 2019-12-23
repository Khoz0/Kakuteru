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
				<li><a href="../A_Propos/a_propos.php" accesskey="5" title="">A propos de nous</a></li>
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
					if (isset($_POST["submit"])){

					    //Tous les champs non obligatoires peuvent être null
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

						//On vérifie que l'email entré n'est pas celui d'un autre utilisateur déjà inscrit
						if ($donnees = $results->fetch()){?>
							<em> L'adresse mail : <?= $donnees['login'];?> est déjà utilisée</em>
							<br>
						<?php
						}

						//Le mail n'est pas utilisé par quelqu'un d'autre
						else{

						    //On vérifie que le mot de passe fait moins de 16 caractère
							if (strlen($_POST["mdp"]) <= 16){
								$email = $_POST["email"];
								$mdp = $_POST["mdp"];
								$sexe = $_POST["sexe"];

								//Si les champs obligatoires ne sont pas vides, on enregistre leur valeur
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

								//On insère tous les champs dans la base de données
								$stmt = $bdd->prepare("INSERT INTO Utilisateur (nom, prenom, login, mdp, sexe, adresse, postal, ville, noTelephone) VALUES (:nom, :prenom, :login, SHA1(:mdp), :sexe, :adresse, :postal, :ville, :noTelephone)");
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
                                $_SESSION['login'] = $email;
								if (isset($_SESSION['login'])){
									header("Location: ../");
								}
							}

							//Le mot de passe fait plus de 16 caractères
							else{
								?> <em>Le mot de passe doit contenir moins de 16 caractères<br><br></em><?php
							}
						}
					}
					?>

					<label for="email">Email <em>*</em></label>
                  <!--L'email doit correspondre à l'expression régulière donnée-->
					<input name="email" type="email" placeholder="Email" required="" pattern="[aA0-zZ9]+[.]?[aA0-zZ9]*@[aA-zZ]*[.]{1}[aA-zZ]+"><br>
					<label for="mdp">Mot de passe <em>*</em></label>
					<input name="mdp" type="password" required = ""><br>
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
                  <!--Le code postal doit correspondre à l'expression régulière donnée-->
					<input name="postal" pattern="[0-9]{5}"><br>
					<label for="ville">Ville</label>
					<input name="ville"><br>
					<label for="telephone">Téléphone</label>
                  <!--Le numéro de téléphone doit correspondre à l'expression régulière donnée-->
					<input name="telephone" type="tel" placeholder="0xxxxxxxxx" pattern="0[3, 6, 9, 7, 2][0-9]{8}"><br>
			  </fieldset>
			  <p><input name = "submit" type="submit" value="Créer le compte"></p>
			</form>
		</div>
	</div>
</div>
</body>
</html>
