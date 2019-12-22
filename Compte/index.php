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
	// On regarde si l'utilisateur est connecté afin de savoir quel bouton afficher
	if (isset($_SESSION['login'])){
		// L'utilisateur est ici connecté on affiche donc le bouton de déconnexion
	?>
		<button onclick = "location.href='../Deconnexion/'" class="button" style=vertical-align:middle>Déconnexion</button>
	<?php
	}else{
		// L'utilisateur est ici déconnecté on affiche donc le bouton de connexion
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
				<li><a href="../Cocktails/" accesskey="2" title="">Nos cocktails</a></li>
				<li><a href="../Recettes/" accesskey="3" title="">Nos recettes</a></li>
				<?php if (isset($_SESSION['login'])){ ?>
				<li><a href="#" accesskey="4" title="">Mon compte</a></li>
				<?php } ?>
				<li><a href="../A_Propos/a_propos.php" accesskey="5" title="">A propos de nous</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="wrapper">
	<h2>
	<?php
	$requete = $bdd->prepare("SELECT * FROM Utilisateur WHERE login = :loginSession");
	$loginSession = $_SESSION['login'];
	$requete->bindParam('loginSession', $loginSession);
	$requete->execute();
	if($donnees = $requete->fetch()){
		if ($donnees['nom'] != 'null'){
			echo "Espace personnel du membre : ".$donnees['nom'];
		}else{
		echo "Espace personnel du membre : ".$donnees['login'];
		}
	}
	?>
	</h2>
	<br><br>
	<div id="page" class="container">
		<div class="boxA">
			<form class="" action="#" method="post">
				<?php
				// On vérifie ici que l'utilisateur a appuyé sur le bouton de validation des changements
				if (isset($_POST["validation"])){
					// On vérifie ici que si l'utilisateur rentre un mot de passe, alors tous les champs de mots de passe sont rempli.
					if (isset($_POST['ancienMdp']) && !empty($_POST["ancienMdp"])){
						if (SHA1($_POST["ancienMdp"]) == $donnees['mdp']){
							if (isset($_POST['nouveauMdp']) && !empty($_POST["nouveauMdp"]) && $_POST["nouveauMdp"] != $_POST['ancienMdp']){
								if (isset($_POST['confirmationMdp']) && !empty($_POST["confirmationMdp"]) && $_POST['nouveauMdp'] == $_POST['confirmationMdp']){
									$requete = $bdd->prepare("UPDATE Utilisateur SET mdp = SHA1(:mdpChanger) WHERE login = :loginSession");
									$loginSession = $_SESSION['login'];
									$mdpChanger = $_POST['confirmationMdp'];
									$requete->bindParam('loginSession', $loginSession);
									$requete->bindParam('mdpChanger', $mdpChanger);
									$requete->execute();
									echo "Nouveau mdp créé";
								}else{
									?> <em> Mot de passe de confirmation manquant ou différents du nouveau mot de passe </em> <?php
								}
							}else{
									?> <em> Nouveau mot de passe manquant ou identique à l'ancien </em> <?php
							}
						}else{
							?> <em> Mot de passe différent du mot de passe de l'utilisateur </em> <?php
						}
					}
					// On fait les différents tests afin de modifier les données de l'utilisateur

					// On vérifie que le mail entré n'est ni vide, ni le même que celui contenu dans la base de données
					if ($donnees['login'] != $_POST['email'] && !empty($_POST['email'])){
						$requete = $bdd->prepare("UPDATE Utilisateur SET login = :login WHERE login = :login");
						$nouveauLogin = $_POST['email'];
						$requete->bindParam('login', $nouveauLogin);
						$requete->execute();
						?> <p>Modification enregistrée.</p><br/><?php
					}else{
						?> <p>Aucune modification n'a été apportée au mail.</p><br/><?php
					}
					// On vérifie que l'adresse entrée n'est ni vide, ni la même que celle contenue dans la base de données
					if ($donnees['adresse'] != $_POST['adresse'] && !empty($_POST['adresse'])){
						$requete = $bdd->prepare("UPDATE Utilisateur SET adresse = :adr WHERE login = :login");
						$loginSession = $_SESSION['login'];
						$adr = $_POST['adresse'];
						$requete->bindParam('login', $loginSession);
						$requete->bindParam('adr', $adr);
						$requete->execute();
						?> <p>Modification enregistrée.</p><br/><?php
					}else{
						?> <p>Aucune modification n'a été apportée à l'adresse.</p><br/><?php
					}
					// On vérifie que le nom entré n'est ni vide, ni le même que celui contenu dans la base de données
					if ($donnees['nom'] != $_POST['nom'] && !empty($_POST['nom'])){
						$requete = $bdd->prepare("UPDATE Utilisateur SET nom = :nom WHERE login = :login");
						$loginSession = $_SESSION['login'];
						$nom = $_POST['nom'];
						$requete->bindParam('login', $loginSession);
						$requete->bindParam('nom', $nom);
						$requete->execute();
						?> <p>Modification enregistrée.</p><br/><?php
					}else{
						?> <p>Aucune modification n'a été apportée au nom.</p><br/><?php
					}
					// On vérifie que le prenom entré n'est ni vide, ni le même que celui contenu dans la base de données
					if ($donnees['prenom'] != $_POST['prenom'] && !empty($_POST['prenom'])){
						$requete = $bdd->prepare("UPDATE Utilisateur SET prenom = :prenom WHERE login = :login");
						$loginSession = $_SESSION['login'];
						$prenom = $_POST['prenom'];
						$requete->bindParam('login', $loginSession);
						$requete->bindParam('prenom', $prenom);
						$requete->execute();
						?> <p>Modification enregistrée.</p><br/><?php
					}else{
						?> <p>Aucune modification n'a été apportée au prénom.</p><br/> <?php
					}
					// On vérifie que le code postal entré n'est ni vide, ni le même que celui contenu dans la base de données
					if ($donnees['postal'] != $_POST['postal'] && !empty($_POST['postal'])){
						$requete = $bdd->prepare("UPDATE Utilisateur SET postal = :postal WHERE login = :login");
						$loginSession = $_SESSION['login'];
						$postal = $_POST['postal'];
						$requete->bindParam('login', $loginSession);
						$requete->bindParam('postal', $postal);
						$requete->execute();
						?> <p>Modification enregistrée.</p><br/> <?php
					}else{
						?> <p>Aucune modification n'a été apportée au code postal.</p><br/> <?php
					}
					// On vérifie que le sexe entré n'est ni vide, ni le même que celui contenu dans la base de données
					if ($donnees['sexe'] != $_POST['sexe'] && !empty($_POST['sexe'])){
						$requete = $bdd->prepare("UPDATE Utilisateur SET sexe = :sexe WHERE login = :login");
						$loginSession = $_SESSION['login'];
						$sexe = $_POST['sexe'];
						$requete->bindParam('login', $loginSession);
						$requete->bindParam('sexe', $sexe);
						$requete->execute();
						?> <p>Modification enregistrée.</p><br/> <?php
					}else{
						?> <p>Aucune modification n'a été apportée au sexe.</p><br/> <?php
					}
					// On vérifie que le numéro de téléphone entré n'est ni vide, ni le même que celui contenu dans la base de données
					if ($donnees['noTelephone'] != $_POST['telephone'] && !empty($_POST['telephone'])){
						$requete = $bdd->prepare("UPDATE Utilisateur SET noTelephone = :telephone WHERE login = :login");
						$loginSession = $_SESSION['login'];
						$telephone = $_POST['telephone'];
						$requete->bindParam('login', $loginSession);
						$requete->bindParam('telephone', $telephone);
						$requete->execute();
						?> <p>Modification enregistrée.</p><br/> <?php
					}else{
						?> <p>Aucune modification n'a été apportée au numéro de téléphone.</p><br/> <?php
					}
					// On vérifie que la ville entrée n'est ni vide, ni la même que celle contenue dans la base de données
					if ($donnees['ville'] != $_POST['ville'] && !empty($_POST['ville'])){
						$requete = $bdd->prepare("UPDATE Utilisateur SET ville = :ville WHERE login = :login");
						$loginSession = $_SESSION['login'];
						$ville = $_POST['ville'];
						$requete->bindParam('login', $loginSession);
						$requete->bindParam('ville', $ville);
						$requete->execute();
						?> <p>Modification enregistrée.</p><br/> <?php
					}else{
						?> <p>Aucune modification n'a été apportée à la ville.</p><br/> <?php
					}
					?>
					<button name="retour" action="./"> Retour </button>
					<?php
				// On vérifie que l'utilisateur a appuyé sur le bouton de modification des informations du compte
				}else if (isset($_POST["modification"])){
					// On rempli les champs du formulaire avec les informations contenues dan sla base de données s'il y en a,
					// sinon on met un placeholder afin d'indiquer quel champs correspond à quelle information à modifier
					?>
					<input name="email" type="email" pattern="[aA0-zZ9]+[.]?[aA0-zZ9]*@[aA-zZ]*[.]{1}[aA-zZ]+" value=<?= $donnees['login'] ?>><br><br>
					<?php if ($donnees['nom'] != "null"){ $nom = htmlspecialchars($donnees['nom'], ENT_QUOTES);?>
						<input name="nom" value='<?= $nom ?>'><br><br>
					<?php }else{ ?>
						<input name="nom" placeholder="Nouveau nom" ><br><br>
					<?php }
					if ($donnees['prenom'] != "null"){ $prenom = htmlspecialchars($donnees['prenom'], ENT_QUOTES);?>
						<input name="prenom" value='<?= $prenom ?>'><br><br>
					<?php }else{ ?>
						<input name="prenom" placeholder="Nouveau prenom"><br><br>
					<?php } ?>
					<select name="sexe">
						<option value="default" name="bdd"><?= $donnees['sexe'] ?></option>
						<option value="N" name="aucun">Non renseigné</option>
						<option value="F" name="homme">Femme</option>
						<option value="H" name="femme">Homme</option>
					</select><br><br>
					<?php
					if ($donnees['adresse'] != "null"){ $adresse = htmlspecialchars($donnees['adresse'], ENT_QUOTES);?>
						<input name="adresse" value='<?= $adresse ?>'><br><br>
					<?php }else{ ?>
						<input name="adresse" placeholder="Nouvelle adresse"><br><br>
					<?php }
					if ($donnees['postal'] != 0){ ?>
						<input name="postal" pattern="[0-9]{5}" value=<?= $donnees['postal'] ?>><br><br>
					<?php }else{ ?>
						<input name="postal" placeholder="Nouveau code postal" pattern="[0-9]{5}"><br><br>
					<?php }
					if ($donnees['ville'] != "null"){ $ville = htmlspecialchars($donnees['ville'], ENT_QUOTES);?>
						<input name="ville" value='<?= $ville ?>'><br><br>
					<?php }else{ ?>
						<input name="ville" placeholder="Nouvelle ville"><br><br>
					<?php }
					if ($donnees['noTelephone'] != 0){ ?>
						<input name="telephone" type="tel" pattern="0[3, 6, 9, 7, 2, 1][0-9]{8}" value=<?= $donnees['noTelephone'] ?>><br><br>
					<?php }else{ ?>
						<input name="telephone" type="tel" placeholder="0xxxxxxxxx" pattern="0[3, 6, 9, 7, 2][0-9]{8}"><br><br>
					<?php } ?>
					<br>
					<input name="ancienMdp" type="password" placeholder="Ancien mot de passe"><br><br>
					<input name="nouveauMdp" type="password" placeholder="Nouveau mot de passe"><br><br>
					<input name="confirmationMdp" type="password" placeholder="Confirmation du nouveau mot de passe"><br><br>
					<br>
					<p><input name = "validation" type="submit" value="Enregistrer"></p>
				<?php }else{
					// On affiche les informations du compte de l'utilisateur
					?>
					<p>Email : <?php echo $donnees['login']; ?> </p>
					<p>Nom : <?php echo $donnees['nom']; ?> </p>
					<p>Prenom : <?php echo $donnees['prenom']; ?> </p>
					<p>Sexe : <?php echo $donnees['sexe']; ?> </p>
					<p>Adresse : <br><?= $donnees['adresse'].' '.$donnees['postal'].' '.$donnees['ville']; ?></p>
					<p>N° de téléphone : <?php echo $donnees['noTelephone']; ?> </p>
					<p><input name = "modification" type="submit" value="Modifier Informations"></p>
					<?php
				}
				?>
				<br>
			</form>
		</div>
		<div class="boxC">
			<form class="" action="#" method="post">
				<p>Email : <?php echo $_SESSION['login']; ?> </p>
				<?php if (isset($_POST["suppression"])){
					// On supprime k'utilisateur de la base de données si le bouton de suppression a été pressé
					$requete = $bdd->prepare("DELETE FROM Utilisateur WHERE login = :login");
					$login = $_SESSION['login'];
					$requete->bindParam('login', $login);
					$requete->execute();
					$_SESSION = array();
					session_destroy();
					unset($_SESSION);
					header("Location: ../");
				} ?>
				<br>
				<p><input name = "suppression" type="submit" value="Supprimer le compte"></p>
			</form>
		</div>
	</div>
</div>
</body>
</html>
