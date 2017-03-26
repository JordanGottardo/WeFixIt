<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Inserimento impresa");
printMenu();
printSectionStart("Inserisci una nuova impresa:");

echo <<<EOF
<form action="confirmImpresa.php" method="POST" name="formImpresa" id="formImpresa" onSubmit="return checkImpresa();">
	<label for="ragione">Ragione sociale</label>
	<input type="text" name="ragione" id="ragione"><span class="attention">*</span></input>
	<br/>
	<label for="pIva">Partita IVA</label>
	<input type="text" name="pIva" id="pIva"><span class="attention">*</span></input>
	<br/>	
	<label for="indirizzo">Indirizzo</label>
	<input type="text" name="indirizzo" id="indirizzo"><span class="attention">*</span></input>
	<br/>
	<label for="telefono">Numero telefono</label>
	<input type="text" name="telefono" id="telefono"><span class="attention">*</span></input>
	<br/>
	<br/>
	<input type="submit" value="Inserisci impresa" name="sendButton"/>
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
<div>

EOF;

printSectionEnd();
printPageEnd();

$conn=connectDB();

?>