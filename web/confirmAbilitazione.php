<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma inserimento abilitazione");
printMenu();
printSectionStart("");

$idDipendente=$_POST["idDipendente"];
$idMansione=$_POST["idMansione"];
$dataIni=$_POST["dataIni"];

$conn=connectDB();
$query="INSERT INTO Abilitazione VALUES
('$idDipendente', '$idMansione', '$dataIni')";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

echo	<<<EOF
<div id="confirmed">
	Hai provato ad inserire:
	<ul>
		<li>Dipendente: $idDipendente</li>
		<li>Mansione: $idMansione</li>
		<li>Data inizio: $dataIni</li>
	</ul>
	
EOF;

$query="SELECT * FROM Abilitazione WHERE Dipendente='$idDipendente' AND Mansione='$idMansione'" ;
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row=mysqli_fetch_row($result);

echo	<<<EOF
	<br/>
	<hr/>
	<br/>
	Hai inserito:
	<ul>
		<li>Dipendente: $row[0]</li>
		<li>Mansione: $row[1]</li>
		<li>Data inizio: $row[2]</li>
	</ul>
</div>
EOF;

printSectionEnd();
printPageEnd();
?>