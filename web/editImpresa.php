<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Modifica impresa");
printMenu();
printSectionStart("Modifica impresa:");

$conn=connectDB();
$idImpresa=$_POST["idImpresa"];
//missing
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($result);

echo <<<EOF
<form action="confirmEditImpresa.php" method="POST" name="formImpresa" id="formImpresa" onSubmit="return checkImpresa();">
	<label for="id">Id</label>
	<input type="hidden" name="id" id="id" value="$idImpresa">$idImpresa</input>
	<br/>
	<label for="ragione">Ragione sociale</label>
	<input type="text" name="ragione" id="ragione" value="$row[1]"><span class="attention">*</span></input>
	<br/>
	<label for="codFiscale">Partita Iva</label>
	<input type="text" name="pIva" id="pIva" value="$row[2]"><span class="attention">*</span></input>
	<br/>	
	<label for="indirizzo">Indirizzo</label>
	<input type="text" name="indirizzo" id="indirizzo" value="$row[3]"><span class="attention">*</span></input>
	<br/>
	<label for="telefono">Numero telefono</label>
	<input type="text" name="telefono" id="telefono" value="$row[4]"><span class="attention">*</span></input>
	<br/>
	<br/>
	<input type="submit" value="Modifica impresa" name="sendButton"/>
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
<div>

EOF;



printSectionEnd();
printPageEnd();
?>