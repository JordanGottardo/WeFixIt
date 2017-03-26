<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Funzione 2 ");
printMenu();
printSectionStart("Funzione che riceve in input due decimali ed un booleano. Se il booleano è false ritorna la lista degli incarichi per cui è stata emessa una fattura con imponibile compreso tra i due valori forniti, se il booleano è true la verifica dei limiti è fatta tenendo conto anche dell’aliquota.
");


echo <<<EOF
<form action="confirmFunzione2.php" method="POST" name="formFunzione2" id="formFunzione2" onSubmit="return checkFunzione2();">
	<label for="X">X</label>
	<input type="text" id="X" name="X" maxlength="13" ><span class="attention">*</span></input>
	<br/>
	<label for="Y">Y</label>
	<input type="text" id="Y" name="Y" maxlength="13"><span class="attention">*</span></input>
	<br/>
	<label for="IVA">IVA</label>
	<input type="checkbox" name="IVA" id="IVA" value="check"/>
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


