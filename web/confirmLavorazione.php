<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma inserimento lavorazione");
printMenu();
printSectionStart("");

$idIncarico=$_POST["idIncarico"];
$idMansione=$_POST["idMansione"];
$dataIni=$_POST["dataIni"];
$dataFine=$_POST["dataFine"];
$ore=$_POST["ore"];
$costo=$_POST["costo"];
$quantitaHW=$_POST["quantitaHW"];
$idDipendente=$_POST["idDipendente"];


$conn=connectDB();

$query="SELECT Tipo FROM Mansione WHERE ID='$idMansione'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$tipo=mysqli_fetch_array($result);
$tipo=$tipo[0];


$query="SELECT MAX(ID) FROM Lavorazione"; 
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$id=mysqli_fetch_array($result);
$id[0]+=1;




if ($tipo==H)
	$query="INSERT INTO Lavorazione VALUES
('$id[0]', '$dataIni', '$dataFine', '$ore', 0, '$quantitaHW', '$idIncarico', '$idMansione', '$idDipendente')";
else
	$query="INSERT INTO Lavorazione VALUES
('$id[0]', '$dataIni', '$dataFine', '$ore', 0, NULL, '$idIncarico', '$idMansione', '$idDipendente')";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

echo	<<<EOF
<div id="confirmed">
	Hai provato ad inserire la lavorazione:
	<ul>
		<li>Id: $id[0]</li>
		<li>Data inizio: $dataIni</li>
		<li>Data fine: $dataFine</li>
		<li>Ore: $ore</li>
		<li>Costo: $costo</li>
		<li>Quantità HW: $quantitaHW</li>
		<li>Incarico: $idIncarico</li>
		<li>Mansione: $idMansione</li>
		<li>Dipendente: $idDipendente</li>
	</ul>
EOF;

$query="SELECT * FROM Lavorazione WHERE ID='$id[0]'";
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



printSectionEnd();
printPageEnd();
?>