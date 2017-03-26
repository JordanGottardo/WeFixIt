<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Procedura 1 ");
printMenu();
printSectionStart("1. Procedura che prende come input un valore ENUM(H, S, A) ad indicare un tipo di mansione o entrambe, una percentuale (negativa o positiva) espressa come decimale ed un valore limite anche’esso decimale. La procedura seleziona tutte le lavorazioni della tipologia fornita e calcola la media del loro costo. Se la percentuale fornita è negativa ed il risultato della media dei costi è minore del limite fornito allora il prezzo delle mansioni relative viene abbassato della percentuale fornita. Se la percentuale è positiva invece e la media maggiore del limite il prezzo viene aumentato della percentuale in input.
");


echo <<<EOF
<form action="confirmProcedura1.php" method="POST" name="formProcedura1" id="formProcedura1" onSubmit="return checkProcedura1();">
	<label for="tipo">Tipo mansione</label>
	<select name="tipo" id="tipo">
		<option value="S">S</option>
		<option value="H">H</option>
		<option value="A">S/H</option>
	</select> 
	<br/>
	<label for="percentuale">Percentuale</label>
	<input type="text" id="percentuale" name="percentuale" maxlength="6" ><span class="attention">*</span></input>
	<br/>
	<label for="limite">Limite</label>
	<input type="text" id="limite" name="limite" maxlength="13" ><span class="attention">*</span></input>
	<br/>
	<input type="submit" value="Esegui procedura" name="sendButton"/>

</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;



printSectionEnd();
printPageEnd();
?>


