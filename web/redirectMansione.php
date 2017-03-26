<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

session_start();

$idIncarico=$_POST["idIncarico"];
$_SESSION['idIncarico']=$idIncarico;

$tipoMansione=$_POST["tipoMansione"];


if ($tipoMansione=="mansioneSoftware")
	header("location: viewMansioneSoftware.php?request=insertLavorazione");
else
	header("location: viewMansioneHardware.php?request=insertLavorazione");