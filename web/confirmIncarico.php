<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma inserimento incarico");
printMenu();
printSectionStart("");

$idCliente=$_POST["idCliente"];
$dataIni=$_POST["dataIni"];

$conn=connectDB();
$query="SELECT MAX(ID) FROM Incarico"; 
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$id=mysqli_fetch_array($result);
$id[0]+=1;
$query="INSERT INTO Incarico VALUES
('$id[0]', '$dataIni', NULL, '$idCliente')";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));



echo	<<<EOF
<div id="confirmed">
	Hai appena inserito l'incarico
	<ul>
		<li>Id: $id[0]</li>
		<li>Data inizio: $dataIni</li>
		<li>Cliente: $idCliente</li>
	</ul>
	
EOF;

$query="SELECT * FROM Incarico WHERE ID='$id[0]'";
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
		<li>Cliente: $row[3]</li>
	</ul>
</div>
EOF;




printSectionEnd();
printPageEnd();
?>