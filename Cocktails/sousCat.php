<?php
session_start();
$cat = $_GET['p'];
$_SESSION['supCategorie'][$cat] = 1;
$_SESSION['categorieCourante'] = $cat;
