<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Modifica cliente");
printMenu();
printSectionStart("Modifica i dati di un cliente :");


$idCliente=$_POST["idCliente"];
$tipo=$_POST["type"];

$conn=connectDB();
$query="SELECT * FROM Cliente WHERE ID='$idCliente'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($result);


if ($tipo=="privato")
{
	echo <<<EOF
<form action="confirmEditCliente.php" method="POST" name="formCliente" id="formCliente" onSubmit="return checkClientePrivato();">
EOF;
}
elseif ($tipo=="impresa")
{
	echo <<<EOF
<form action="confirmEditCliente.php" method="POST" name="formCliente" id="formCliente" onSubmit="return checkImpresa();">
EOF;
}

echo <<<EOF
	<input type="hidden" name="type" value="$tipo" />
	<label for="idCliente">ID</label>
	<input type="hidden" name="idCliente" id="idCliente" value="$idCliente">$idCliente</input>
	<br/>
	<label for="tipo">Tipo</label>
	<input type="hidden" name="tipo" id="tipo">$row[1]</input>
	<br/>
	<label for="nominativo">Nominativo</label>
	<input type="text" name="nominativo" id="nominativo" value="$row[2]" maxlength="50"><span class="attention">*</span></input>
	<br/>

EOF;

if ($tipo=="privato")
{
echo<<<EOF
	<label for="codFiscale">Codice fiscale</label>
	<input type="text" name="codFiscale" id="codFiscale" maxlength="16" value="$row[3]"><span class="attention">*</span></input>
	<br/>
EOF;
}
elseif ($tipo=="impresa")
{
		echo<<<EOF
	<label for="pIva">Partita Iva</label>
	<input type="text" name="pIva" id="pIva" value="$row[4]" maxlength="11"><span 
class="attention">*</span></input>
	<br/>
EOF;
}
	
echo<<<EOF
	<label for="indirizzo">Indirizzo</label>
	<input type="text" name="indirizzo" id="indirizzo" value="$row[5]" maxlength="50"><span class="attention">*</span></input>
	<br/>
	<label for="citta">Città</label>
	<input type="citta" name="citta" id="citta" value="$row[6]" maxlength="30"><span class="attention">*</span></input>
	<br/>
	<label for="telefono">Numero telefono</label>
	<input type="text" name="telefono" id="telefono" value="$row[7]" maxlength="11"><span class="attention">*</span></input>
	<br/>
	<br/>
	<input type="submit" value="Modifica cliente" name="sendButton"/>
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;



printSectionEnd();
printPageEnd();
?>