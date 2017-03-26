<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma inserimento cliente");
printMenu();
printSectionStart("Conferma inserimento cliente");

$nominativo=$_POST["nominativo"];
$indirizzo=$_POST["indirizzo"];
$citta=$_POST["citta"];
$telefono=$_POST["telefono"];
$tipo=$_POST["type"];

if ($tipo=="privato")
{
	$codFiscale=$_POST["codFiscale"];
	$tp="P";
}
elseif ($tipo=="impresa")
{
	$pIva=$_POST["pIva"];
	$tp="I";
}

$conn=connectDB();
$query="SELECT MAX(ID) FROM Cliente";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$id=mysqli_fetch_array($result);
$id[0]+=1;

if ($tipo=="privato")
	$query="INSERT INTO Cliente VALUES
('$id[0]', '$tp', '$nominativo', '$codFiscale', NULL, '$indirizzo', '$citta', '$telefono')";
	elseif ($tipo=="impresa")
$query="INSERT INTO Cliente VALUES
('$id[0]', '$tp', '$nominativo', NULL, '$pIva', '$indirizzo', '$citta', '$telefono')";

$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
	
	
echo	<<<EOF
<div id="confirmed">
	Hai provato ad inserire:
	<ul>
		<li>ID: $id[0]</li>
		<li>Tipo: $tp</li>
		<li>Nominativo: $nominativo</li>
EOF;

if ($tipo=="privato")
{
	echo<<<EOF
		<li>Codice fiscale: $codFiscale</li>
EOF;
}
elseif ($tipo=="impresa")
{
	echo<<<EOF
		<li>Partita Iva: $pIva</li>
EOF;
}

echo<<<EOF
		<li>Indirizzo: $indirizzo</li>
		<li>Città: $citta</li>
		<li>Telefono: $telefono</li>
	</ul>
EOF;

$query="SELECT * FROM Cliente WHERE ID='$id[0]'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row=mysqli_fetch_row($result);

echo<<<EOF
	<br/>
	<hr/>
	<br/>
	Hai inserito:
	<ul>
		<li>ID: $row[0]</li>
		<li>Tipo: $row[1]</li>
		<li>Nominativo: $row[2]</li>
EOF;
if ($tipo=="privato")
{
	echo<<<EOF
		<li>Codice fiscale: $row[3]</li>
EOF;
}
elseif ($tipo=="impresa")
{
	echo<<<EOF
		<li>Partita Iva: $row[4]</li>
EOF;
}

echo<<<EOF
		<li>Indirizzo: $row[5]</li>
		<li>Città: $row[6]</li>
		<li>Telefono: $row[7]</li>
	</ul>
</div>
EOF;


printSectionEnd();
printPageEnd();
?>