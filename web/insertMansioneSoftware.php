<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Inserimento mansione software");
printMenu();
printSectionStart("Inserisci mansione software");

echo <<<EOF
<form action="confirmMansioneSoftware.php" method="POST" name="formSoftware" id="formSoftware" onSubmit="return checkSoftware();">
	<label for="descrizione">Descrizione</label>
	<input type="text" name="descrizione" id="descrizione"><span class="attention">*</span></input>
	<br/>
	<label for="pOrario">Prezzo Orario</label>
	<input type="text" name="pOrario" id="pOrario"><span class="attention">*</span></input>	
	<br/>
	<input type="submit" value="Inserisci mansione software" name="sendButton"/>

</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
<div>

EOF;

printSectionEnd();
printPageEnd();

$conn=connectDB();

?>