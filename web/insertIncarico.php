<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Inserimento nuovo incarico");
printMenu();
printSectionStart("Inserisci i dati del nuovo incarico: ");

$idCliente=$_POST["idCliente"];

echo <<<EOF
<form action="confirmIncarico.php" method="POST" name="formIncarico" id="formIncarico" onSubmit="return checkIncarico();">
	<label for="idCliente">Cliente</label>
	<input type="hidden" id="idCliente" name="idCliente" value="$idCliente">$idCliente</input>
	<br/>
	<label for="dataIni">Data inizio</label>
	<input type="text" name="dataIni" id="dataIni" maxlength="10"><span class="attention" maxlength="10">*</span> (Formato AAAA-MM-GG)</input>
	<br/>
	<input type="submit" value="Inserisci incarico" name="sendButton"/>

</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;

printSectionEnd();
printPageEnd();

?>