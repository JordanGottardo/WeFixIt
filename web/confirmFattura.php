<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma inserimento fattura");
printMenu();
printSectionStart("");

$data=$_POST["data"];
$aliquota=$_POST["aliquota"];
$idIncarico=$_POST["idIncarico"];

$conn=connectDB();
$query="SELECT MAX(ID) FROM Fattura";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$id=mysqli_fetch_array($result);
$id[0]+=1;
$query="INSERT INTO Fattura VALUES
('$id[0]', '$data', '0', '$aliquota', '$idIncarico')";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));




echo	<<<EOF
<div id="confirmed">
	Hai provato ad inserire:
	<ul>
		<li>Id: $id[0]</li>
		<li>Data: $data</li>
		<li>Aliquota: $aliquota</li>
		<li>Incarico: $idIncarico</li>
	</ul>
EOF;

$query="SELECT * FROM Fattura WHERE ID='$id[0]'";
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