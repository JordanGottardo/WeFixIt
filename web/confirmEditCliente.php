<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Conferma modifica cliente");
printMenu();
printSectionStart("");


$tipo=$_POST["type"];

$idCliente=$_POST["idCliente"];
$nominativo=$_POST["nominativo"];
$indirizzo=$_POST["indirizzo"];
$citta=$_POST["citta"];
$telefono=$_POST["telefono"];

if ($tipo=="privato")
{
	$codFiscale=$_POST["codFiscale"];
	$tp="P";
}
else
{
	$pIva=$_POST["pIva"];
	$tp="I";
}

echo<<<EOF
<div id="confirmed">
	Hai provato a modificare il cliente con i dati:
	<ul>
	<li>Id: $idCliente</li>
	<li>Tipo: $tp </li>
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
		<li>Nominativo: $nominativo</li
		<li>Indirizzo: $indirizzo</li>
		<li>Città: $citta</li>
		<li>Telefono: $telefono</li>
	</ul>
</div>
EOF;

$conn=connectDB();

if ($tipo=="privato")
{
	$query="UPDATE Cliente
SET Nominativo='$nominativo', CodiceFiscale='$codFiscale', PartitaIva=NULL, Indirizzo='$indirizzo', Citta='$citta', Telefono='$telefono'
WHERE ID='$idCliente'";

}
elseif ($tipo=="impresa")
{
	$query="UPDATE Cliente
SET Nominativo='$nominativo', CodiceFiscale=NULL, PartitaIva='$pIva', Indirizzo='$Indirizzo', Citta='$citta'
WHERE ID='$idCliente'";
}
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$query="SELECT * FROM Cliente WHERE ID='$idCliente'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row=mysqli_fetch_row($result);

echo<<<EOF
	<br/>
	<hr/>
	<br/>
	Ora il cliente è:
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