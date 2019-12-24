<?php
session_start();
$cat = $_GET['p'];
$continuer = 1;

foreach ($_SESSION['supCategorie'] as $categorie=>$val){
    echo $cat." ".$categorie."\n";
    if($cat == $categorie){
        echo "Je stoppe en premier à ".$categorie;
        $_SESSION['supCategorie'][$categorie] = 0;
        $continuer = 0;
    }
    if($continuer == 0){
        echo "Je continue de stopper pour ".$categorie;
        $_SESSION['supCategorie'][$categorie] = 0;
    }
}

$derniereCat = "Aliment";
foreach ($_SESSION['supCategorie'] as $categorie=>$val){
    if($val == 0){
        echo "La première val à 0 est ".$categorie;
        $_SESSION['categorieCourante'] = $derniereCat;
    }
else{
        $derniereCat = $categorie;
    }
}