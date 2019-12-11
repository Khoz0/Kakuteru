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
		<button onclick = "location.href='../Deconnexion/index.php'" class="button" style=vertical-align:middle>Déconnexion</button>
	<?php
	}else{
	?>
		<button onclick="window.location.href = '../ConnexionSite/index.php';" class="button" style=vertical-align:middle>Connexion</button>
	<?php } ?>
	<div id="header" class="container">
		<div id="logo">
			<h1><a href="../index.php">Kakuteru</a></h1>
		</div>
		<div id="menu">
			<ul>
				<li class="active"><a href="../index.php" accesskey="1" title="">Accueil</a></li>
				<li><a href="../Cocktails/index.php" accesskey="2" title="">Nos cocktails</a></li>
				<li><a href="../Recettes/index.php" accesskey="3" title="">Nos recettes</a></li>
				<?php if (isset($_SESSION['login'])){ ?>
				<li><a href="../Compte/index.php" accesskey="4" title="">Mon compte</a></li>
				<?php } ?>
				<li><a href="#" accesskey="5" title="">A propos de nous</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="wrapper">
	<h2> SECTION A PROPOS</h2>
</div>

</body>
</html>
