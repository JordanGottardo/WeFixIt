<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma inserimento dipendente");
printMenu();
printSectionStart("");

$nome=$_POST["nome"];
$cognome=$_POST["cognome"];
$dataAssunzione=$_POST["dataAssunzione"];


$conn=connectDB();
$query="SELECT MAX(ID) FROM Dipendente";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$id=mysqli_fetch_array($result);
$id[0]+=1;
$query="INSERT INTO Dipendente VALUES
('$id[0]', '$nome', '$cognome', '$dataAssunzione')";

$result=mysqli_query($conn, $query) or die(mysqli_error($conn));



echo	<<<EOF
<div id="confirmed">
	Hai provato ad inserire il dipendente con i dati:
	<ul>
		<li>Id: $id[0]</li>
		<li>Nome: $nome</li>
		<li>Cognome: $cognome</li>
		<li>Data assunzione: $dataAssunzione</li>
	</ul>
EOF;

$query="SELECT * FROM Dipendente WHERE ID='$id[0]'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row=mysqli_fetch_row($result);

echo	<<<EOF
	<br/>
	<hr/>
	<br/>
	Il dipendente inserito è:
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