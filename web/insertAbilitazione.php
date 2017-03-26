<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Inserimento abilitazione");
printMenu();
printSectionStart("Inserisci abilitazione");

$idDipendente=$_POST["idDipendente"];
$idMansione=$_POST["idMansione"];

echo <<<EOF
<form action="confirmAbilitazione.php" method="POST" name="formAbilitazione" id="formAbilitazione" onSubmit="return checkAbilitazione();">
	<label for="idDipendente">Dipendente</label>
	<input type="hidden" name="idDipendente" value="$idDipendente">$idDipendente</input>
	<br/>
	<label for="idMansione">Mansione</label>
	<input type="hidden" name="idMansione" value="$idMansione">$idMansione</input>
	<br/>
	<label for="dataIni">Data inizio</label>
	<input type="text" name="dataIni" id="dataIni" maxlength="10"><span class="attention">*</span> (Formato AAAA-MM-GG)</input>
	<br/>
	<input type="submit" value="Inserisci abilitazione" name="sendButton"/>
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;

printSectionEnd();
printPageEnd();

?>