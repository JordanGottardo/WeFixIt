<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma modifica mansione software");
printMenu();
printSectionStart("");

$idMansioneSoftware=$_POST["idMansioneSoftware"];
$descrizione=$_POST["descrizione"];
$pOrario=$_POST["pOrario"];

echo	<<<EOF
<div id="confirmed">
	La mansione software appena modificata è:
	<ul>
		<li>Id: $idMansioneSoftware</li>
		<li>Descrizione: $descrizione</li>
		<li>Prezzo orario: $pOrario</li>
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