<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma inserimento mansione software");
printMenu();
printSectionStart("");

$descrizione=$_POST["descrizione"];
$pOrario=$_POST["pOrario"];


echo	<<<EOF
<div id="confirmed">
	Hai appena inserito la mansione software:
	<ul>
		<li>Descrizione: $descrizione</li>
		<li>Prezzo orario: $pOrario</li>
	<ul>
	
</div>
EOF;

$conn=connectDB();
$query="SELECT MAX(idOspedale) FROM Ospedali";
$res=mysqli_query($conn, $query) or die(mysqli_error($conn));
$id=mysqli_fetch_array($result);
$id[0]+=1;
//missing
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

printSectionEnd();
printPageEnd();
?>