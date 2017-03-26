<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma inserimento mansione");
printMenu();
printSectionStart("");

$tipo=$_POST["type"];
$descrizione=$_POST["descrizione"];
$pOrario=$_POST["prezzo"];
if ($tipo=="hardware")
{
	$costoHW=$_POST["costoHW"];
	$tp="H";
}
elseif ($tipo=="software")
	$tp="S";


$conn=connectDB();
$query="SELECT MAX(ID) FROM Mansione";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$id=mysqli_fetch_array($result);
$id[0]+=1;

if ($tipo=="hardware")
	$query="INSERT INTO Mansione VALUES
('$id[0]', '$tp', '$descrizione', '$pOrario', '$costoHW')";
elseif($tipo=="software")
	$query="INSERT INTO Mansione VALUES
('$id[0]', '$tp', '$descrizione', '$pOrario', NULL)";

$result=mysqli_query($conn, $query) or die(mysqli_error($conn));


echo	<<<EOF
<div id="confirmed">
	Hai provato ad inserire la mansione:
	<ul>
		<li>ID: $id[0]</li>
		<li>Tipo: $tp</li>
		<li>Descrizione: $descrizione</li>
		<li>Prezzo orario: $pOrario</li>
EOF;
if ($tipo=="hardware")
{
	
	echo<<<EOF
		<li>Costo hardware: $costoHW</li>
EOF;
}
echo<<<EOF
	</ul>
	
EOF;

$query="SELECT * FROM Mansione WHERE ID='$id[0]'";
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
if ($tipo=="hardware")
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