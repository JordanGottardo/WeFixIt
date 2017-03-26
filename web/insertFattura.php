<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Inserimento fattura");
printMenu();
printSectionStart("Inserisci fattura");

$idIncarico=$_POST["idIncarico"];

echo <<<EOF
<form action="confirmFattura.php" method="POST" name="formFattura" id="formFattura" onSubmit="return checkFattura();">
	<label for="data">Data</label>
	<input type="text" name="data" id="data" maxlength="10"><span class="attention">*</span> (Formato AAAA-MM-GG)</input>
	<br/>
	<label for="aliquota">Aliquota</label>
	<input type="text" name="aliquota" id="aliquota" maxlength="5"><span class="attention">*</span> Formato NN,nn (ad es. 22,00)</input>	
	<br/>
	<label for="idIncarico">Incarico</label>
	<input type="hidden" name="idIncarico" id="idIncarico" value="$idIncarico">$idIncarico</input>
	<br/>
	<input type="submit" value="Inserisci fattura" name="sendButton"/>
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;

printSectionEnd();
printPageEnd();


?>