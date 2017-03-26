<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Inserimento dipendente");
printMenu();
printSectionStart("Inserisci dipendente");


echo <<<EOF
<form action="confirmDipendente.php" method="POST" name="formDipendente" id="formDipendente" onSubmit="return checkDipendente();">
	<label for="nome">Nome</label>
	<input type="text" name="nome" id="nome" maxlength="50"><span class="attention">*</span></input>
	<br/>
	<label for="cognome">Cognome</label>
	<input type="text" name="cognome" id="cognome" maxlength="50"><span class="attention">*</span></input>	
	<br/>
	<label for="dataAssunzione">Data assunzione</label>
	<input type="text" name="dataAssunzione" id="dataAssunzione" maxlength="10"><span class="attention">*</span>Formato AAAA-MM-GG</input>	
	<br/>
	<input type="submit" value="Inserisci dipendente" name="sendButton"/>
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;

printSectionEnd();
printPageEnd();


?>