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
									$requete->bindParam('login', $loginSession);
									$requete->bindParam('mdpChanger', $mdpChanger);
									echo SHA1($mdpChanger);
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
					if ($donnees['login'] != $_POST['email']){
						$requete = $bdd->prepare("UPDATE Utilisateur SET login = :login WHERE login = :login");
						$nouveauLogin = $_POST['email'];
						$requete->bindParam('login', $nouveauLogin);
						$requete->execute();
						echo "nouveau mail créé";
					}
					if ($donnees['adresse'] != $_POST['adresse']){
						$requete = $bdd->prepare("UPDATE Utilisateur SET adresse = :adr WHERE login = :login");
						$adr = $_POST['adresse'];
						$requete->bindParam('adr', $adr);
						$requete->execute();
						echo "nouvelle adresse créée";
					}
					if ($donnees['nom'] != $_POST['nom']){
						$requete = $bdd->prepare("UPDATE Utilisateur SET nom = :nom WHERE login = :login");
						$nom = $_POST['nom'];
						$requete->bindParam('nom', $nom);
						$requete->execute();
						echo "nouveau nom créé";
					}
					if ($donnees['prenom'] != $_POST['prenom']){
						$requete = $bdd->prepare("UPDATE Utilisateur SET prenom = :prenom WHERE login = :login");
						$prenom = $_POST['prenom'];
						$requete->bindParam('prenom', $prenom);
						$requete->execute();
						echo "nouveau prenom créé";
					}
					if ($donnees['postal'] != $_POST['postal']){
						$requete = $bdd->prepare("UPDATE Utilisateur SET postal = :postal WHERE login = :login");
						$postal = $_POST['postal'];
						$requete->bindParam('postal', $postal);
						$requete->execute();
						echo "nouveau code postal créé";
					}
					if ($donnees['sexe'] != $_POST['sexe']){
						$requete = $bdd->prepare("UPDATE Utilisateur SET sexe = :sexe WHERE login = :login");
						$sexe = $_POST['sexe'];
						$requete->bindParam('sexe', $sexe);
						$requete->execute();
						echo "nouveau sexe créé";
					}
					if ($donnees['telephone'] != $_POST['telephone']){
						$requete = $bdd->prepare("UPDATE Utilisateur SET telephone = :telephone WHERE login = :login");
						$telephone = $_POST['telephone'];
						$requete->bindParam('telephone', $telephone);
						$requete->execute();
						echo "nouveau telephone créé";
					}
					if ($donnees['ville'] != $_POST['ville']){
						$requete = $bdd->prepare("UPDATE Utilisateur SET ville = :ville WHERE login = :login");
						$ville = $_POST['ville'];
						$requete->bindParam('ville', $ville);
						$requete->execute();
						echo "nouvelle ville créée";
					}
				// On vérifie que l'utilisateur a appuyé sur le bouton de modification des informations du compte
				}else if (isset($_POST["modification"])){
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
						<input name="telephone" type="tel" pattern="0[3, 6, 9, 7, 2][0-9]{8}" value=<?= $donnees['noTelephone'] ?>><br><br>
					<?php }else{ ?>
						<input name="telephone" type="tel" placeholder="0xxxxxxxxx" pattern="0[3, 6, 9, 7, 2][0-9]{8}"><br><br>
					<?php } ?>
					<br>
					<input name="ancienMdp" type="password" placeholder="Ancien mot de passe"><br><br>
					<input name="nouveauMdp" type="password" placeholder="Nouveau mot de passe"><br><br>
					<input name="confirmationMdp" type="password" placeholder="Confirmation du nouveau mot de passe"><br><br>
					<br>
					<p><input name = "validation" type="submit" value="Enregistrer"></p>
				<?php }else{ ?>
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
