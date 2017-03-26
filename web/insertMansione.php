<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Inserimento mansione");
printMenu();
printSectionStart("Inserisci mansione");

$tipo=$_GET["type"];

if ($tipo=="software")
{
	echo<<<EOF
	<form action="confirmMansione.php" method="POST" name="formMansione" id="formMansione" onSubmit="return checkSoftware();">
	<label for="tipo">Tipo</label>
	<input type="hidden" name="type" id="type" value="$tipo">S</input>	
EOF;
}
elseif ($tipo=="hardware")
{
	echo<<<EOF
	<form action="confirmMansione.php" method="POST" name="formMansione" id="formMansione" onSubmit="return checkHardware();">
	<label for="tipo">Tipo</label>
	<input type="hidden" name="type" id="type" value="$tipo">H</input>	
EOF;
}

echo <<<EOF
	<br/>
	<label for="descrizione">Descrizione</label>
	<input type="text" name="descrizione" id="descrizione" maxlength="50"><span class="attention">*</span></input>
	<br/>
	<label for="prezzo">Prezzo orario</label>
	<input type="text" name="prezzo" id="prezzo" maxlength="13"><span class="attention" maxlength="13">*</span></input>	
	<br/>
EOF;


if ($tipo=="hardware")
{
	echo<<<EOF
	<label for="CostoHW">Costo hardware</label>
	<input type="text" name="costoHW" id="costoHW" maxlength="13"><span class="attention">*</span></input>	
	<br/>
	<input type="submit" value="Inserisci mansione hardware" name="sendButton"/>
EOF;
}
elseif ($tipo=="software")
{
	echo<<<EOF
	<input type="submit" value="Inserisci mansione software" name="sendButton"/>
EOF;
}	


echo<<<EOF
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;

printSectionEnd();
printPageEnd();


?>