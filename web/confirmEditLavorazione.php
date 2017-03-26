<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma modifica lavorazione");
printMenu();
printSectionStart("");

$idLavorazione=$_POST["idLavorazione"];
$dataIni=$_POST["dataIni"];
$dataFine=$_POST["dataFine"];
$ore=$_POST["ore"];
$quantitaHW=$_POST["quantitaHW"];
$idIncarico=$_POST["idIncarico"];
$idMansione=$_POST["idMansione"];
$idDipendente=$_POST["idDipendente"];



$conn=connectDB();
$query= "UPDATE Lavorazione
SET DataInizio='$dataIni', DataFine='$dataFine', Ore='$ore', QuantitaHW='$quantitaHW'
WHERE ID='$idLavorazione'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

printSectionEnd();
printPageEnd();

echo	<<<EOF
<div id="confirmed">
	Hai provato a modificare la lavorazione con i dati:
	<ul>
		<li>Id: $idLavorazione</li>
		<li>Data inizio: $dataIni</li>
		<li>Data fine: $dataFine</li>
		<li>Ore: $ore</li>
		<li>Quantità HW: $quantitaHW</li>
		<li>Incarico: $idIncarico</li>
		<li>Mansione: $idMansione</li>
		<li>Dipendente: $idDipendente</li>
	</ul>
EOF;

$query="SELECT * FROM Lavorazione WHERE ID='$idDipendente'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row=mysqli_fetch_row($result);


echo<<<EOF
	<br/>
	<hr/>
	<br/>

	Hai inserito:
	<ul>
		<li>Id: $row[0]</li>
		<li>Data inizio: $row[1]</li>
		<li>Data fine: $row[2]</li>
		<li>Ore: $row[3]</li>
		<li>Costo: $row[4]</li>
		<li>Quantità HW: $row[5]</li>
		<li>Incarico: $row[6]</li>
		<li>Mansione: $row[7]</li>
		<li>Dipendente: $row[8]</li>
	</ul>
	</div>
EOF;
?>