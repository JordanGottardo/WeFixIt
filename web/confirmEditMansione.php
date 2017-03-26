<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma modifica mansione");
printMenu();
printSectionStart("");

$idMansione=$_POST["idMansione"];
$tipo=$_POST["type"];
$descrizione=$_POST["descrizione"];
$prezzo=$_POST["prezzo"];
$costoHW=NULL;
if ($tipo=="H")
{
	$tp="H";
	$costoHW=$_POST["costoHW"];
}
elseif ($tipo=="S")
	$tp="S";

$conn=connectDB();
$query= "UPDATE Mansione
SET Descrizione='$descrizione', PrezzoOrario='$prezzo', CostoHW='$costoHW'
WHERE ID='$idMansione'";




echo	<<<EOF
<div id="confirmed">
	Hai provato a modificare la mansione con i dati:
	<ul>
		<li>Id: $idMansione</li>
		<li>Tipo: $tp</li>
		<li>Descrizione: $descrizione</li>
		<li>Prezzo orario: $prezzo</li>
EOF;

if ($tipo=="H")
{
	echo<<<EOF
		<li>Costo hardware: $costoHW</li>
EOF;
}

echo<<<EOF
	</ul>
EOF;

$query="SELECT * FROM Mansione WHERE ID='$idMansione'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row=mysqli_fetch_row($result);

echo	<<<EOF
	<br/>
	<hr/>
	<br/>
	Hai inserito la mansione:
	<ul>
		<li>ID: $row[0]</li>
		<li>Tipo: $row[1]</li>
		<li>Descrizione: $row[2]</li>
		<li>Prezzo orario: $row[3]</li>
EOF;
if ($tipo=="H")
{
	
	echo<<<EOF
		<li>Costo hardware: $row[4]</li>
EOF;
}

echo<<<EOF
	</ul>
</div>
EOF;
printSectionEnd();
printPageEnd();
?>