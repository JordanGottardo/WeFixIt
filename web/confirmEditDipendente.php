<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma modifica dipendente");
printMenu();
printSectionStart("");

$idDipendente=$_POST["idDipendente"];
$nome=$_POST["nome"];
$cognome=$_POST["cognome"];
$dataAssunzione=$_POST["dataAssunzione"];



$conn=connectDB();
$query= "UPDATE Dipendente
SET Nome='$nome', Cognome='$cognome', DataAssunzione='$dataAssunzione'
WHERE ID='$idDipendente'";

$result=mysqli_query($conn, $query) or die(mysqli_error($conn));


echo<<<EOF
<div id="confirmed">
	Hai provato a modificare il dipendente con i dati:
	<ul>
		<li>Id: $idDipendente</li>
		<li>Nome: $nome</li>
		<li>Cognome: $cognome</li>
		<li>Data assunzione: $dataAssunzione</li>
	</ul>
EOF;

$query="SELECT * FROM Dipendente WHERE ID='$idDipendente'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row=mysqli_fetch_row($result);

echo<<<EOF
	<br/>
	<hr/>
	<br/>
	Hai modificato:
	<ul>
		<li>Id: $row[0]</li>
		<li>Nome: $row[1]</li>
		<li>Cognome: $row[2]</li>
		<li>Data assunzione: $row[3]</li>
	</ul>
</div>
EOF;

printSectionEnd();
printPageEnd();

?>