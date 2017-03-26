<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Inserimento mansione hardware");
printMenu();
printSectionStart("Inserisci mansione hardware");

echo <<<EOF
<form action="confirmMansioneHardware.php" method="POST" name="formHardware" id="formHardware" onSubmit="return checkHardware();">
	<label for="descrizione">Descrizione</label>
	<input type="text" name="descrizione" id="descrizione"><span class="attention">*</span></input>
	<br/>
	<label for="pOrario">Prezzo</label>
	<input type="text" name="prezzo" id="prezzo"><span class="attention">*</span></input>	
	<br/>
	<input type="submit" value="Inserisci mansione hardware" name="sendButton"/>

</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
<div>

EOF;

printSectionEnd();
printPageEnd();

$conn=connectDB();

?>