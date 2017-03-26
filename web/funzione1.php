<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Funzione 1 ");
printMenu();
printSectionStart("Funzione che prende in input una città e restituisce la quantità di lavorazioni eseguite da ogni dipendente per clienti che risiedono nella città indicata 
");


echo <<<EOF
<form action="confirmFunzione1.php" method="POST" name="formFunzione1" id="formFunzione1" onSubmit="return checkFunzione1();">
	<label for="citta">Città</label>
	<input type="text" id="citta" name=" citta" maxlength="30" ><span class="attention">*</span></input>
	<br/>
	<input type="submit" value="Esegui funzione" name="sendButton"/>

</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;



printSectionEnd();
printPageEnd();
?>


