<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma inserimento impresa");
printMenu();
printSectionStart("Conferma inserimento impresa");

$ragione=$_POST["ragione"];
$pIva=$_POST["pIva"];
$indirizzo=$_POST["indirizzo"];
$telefono=$_POST["telefono"];

echo	<<<EOF
<div id="confirmed">
	Hai appena inserito l'impresa:
	<ul>
		<li>Ragione sociale: $ragione</li>
		<li>Partita Iva: $pIva</li>
		<li>Indirizzo: $indirizzo</li>
		<li>Telefono: $telefono</li>
	<ul>
	
</div>
EOF;

$conn=connectDB();
$query="SELECT MAX(idOspedale) FROM Ospedali";//
$res=mysqli_query($conn, $query) or die(mysqli_error($conn));
$id=mysqli_fetch_array($result);
$id[0]+=1;
//missing
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

printSectionEnd();
printPageEnd();
?>