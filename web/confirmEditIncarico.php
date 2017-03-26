<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma modifica incarico");
printMenu();
printSectionStart("");

$idIncarico=$_POST["idIncarico"];
$dataIni=$_POST["dataIni"];
$dataFine=$_POST["dataFine"];
$idCliente=$_POST["cliente"];

echo<<<EOF
<div id="confirmed">
	Hai provato a modificare l'incarico con i dati:
	<ul>
		<li>Id: $idIncarico</li>
		<li>Data inizio: $dataIni</li>
		<li>Data fine: $dataFine</li>
		<li>Cliente: $idCliente</li>
	</ul>
EOF;


$conn=connectDB();
if ($dataFine=='')
	$query="UPDATE Incarico
SET DataInizio='$dataIni', DataFine=NULL
WHERE ID='$idIncarico'";
else
	$query="UPDATE Incarico
SET DataInizio='$dataIni', DataFine='$dataFine'
WHERE ID='$idIncarico'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$query="SELECT * FROM Incarico WHERE ID='$idIncarico'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row=mysqli_fetch_row($result);


echo<<<EOF
	<br/>
	<hr/>
	<br/>
	Ora l'incarico è:
	<ul>
		<li>Id: $row[0]</li>
		<li>Data inizio: $row[1]</li>
		<li>Data fine: $row[2]</li>
		<li>Cliente: $row[3]</li>
	</ul>
</div>
EOF;


printSectionEnd();
printPageEnd();

?>