<?php
// Démarrage ou restauration de la session
session_start();
// Réinitialisation du tableau de session
// On le vide intégralement
$_SESSION = array();
// Destruction de la session
session_destroy();
// Destruction du tableau de session
unset($_SESSION);
?>

<html>

<h1 class="title">VOUS ÊTEZ DECONNECTER</h1>
<p>cliquez <a href="../kakuteru.php">ici</a> pour revenir au menu principal</p>

</html>
