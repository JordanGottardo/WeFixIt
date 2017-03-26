<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma modifica impresa");
printMenu();
printSectionStart("");

$ragione=$_POST["ragione"];
$pIva=$_POST["pIva"];
$indirizzo=$_POST["indirizzo"];
$telefono=$_POST["telefono"];

echo	<<<EOF
<div id="confirmed">
	L'impresa appena modificata è:
	<ul>
		<li>Ragione sociale: $ragione</li>
		<li>Partita Iva: $pIva</li>
		<li>Indirizzo: $indirizzo</li>
		<li>Telefono: $telefono</li>
	<ul>
	
</div>
EOF;

$conn=connectDB();
//missing query update
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));


printSectionEnd();
printPageEnd();

$conn=connectDB();

?>