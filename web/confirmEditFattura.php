<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma modifica fattura");
printMenu();
printSectionStart("");

$idFattura=$_POST["idFattura"];
$data=$_POST["data"];
$imponibile=$_POST["imponibile"];
$aliquota=$_POST["aliquota"];
$idIncarico=$_POST["idIncarico"];



$conn=connectDB();
$query= "UPDATE Fattura
SET DataEmissione='$data', Imponibile='$imponibile', Aliquota='$aliquota'
WHERE ID='$idFattura'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

echo<<<EOF
<div id="confirmed">
	Hai provato a modificare la fattura con i dati:
	<ul>
		<li>Id: $idFattura</li>
		<li>Data: $data</li>
		<li>Imponibile: $imponibile</li>
		<li>Aliquota: $aliquota</li>
		<li>Incarico: $idIncarico</li>
	</ul>
EOF;

$query="SELECT * FROM Fattura WHERE ID='$idFattura'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row=mysqli_fetch_row($result);

echo<<<EOF
	<br/>
	<hr/>
	<br/>
	Hai inserito:
	<ul>
		<li>Id: $row[0]</li>
		<li>Data: $row[1]</li>
		<li>Imponibile: $row[2]</li>
		<li>Aliquota: $row[3]</li>
		<li>Incarico: $row[4]</li>
	</ul>
</div>
EOF;

printSectionEnd();
printPageEnd();

?>