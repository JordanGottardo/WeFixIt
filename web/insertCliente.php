<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Inserimento cliente");
printMenu();
printSectionStart("Inserisci un nuovo cliente:");

$tipo=$_GET['type'];

if ($tipo=='privato')
{
	echo <<<EOF
<form action="confirmCliente.php" method="POST" name="formCliente" id="formCliente" onSubmit="return checkClientePrivato();">
EOF;
}
else
{
	echo <<<EOF
<form action="confirmCliente.php" method="POST" name="formCliente" id="formCliente" onSubmit="return checkImpresa();">
EOF;
}

echo <<<EOF
	<label for="nominativo">Nominativo</label>
	<input type="text" name="nominativo" id="nominativo" maxlength="50"><span class="attention">*</span></input>
	<br/>
EOF;

if ($tipo=='privato')
{
	echo<<<EOF
	<label for="codFiscale">Codice fiscale</label>
	<input type="text" name="codFiscale" id="codFiscale" maxlength="16"><span class="attention">*</span></input>
	<input type="hidden" name="type" value="privato" />
EOF;
}
elseif ($tipo=='impresa')
{
	echo<<<EOF
	<label for="pIva">Partita IVA</label>
	<input type="text" name="pIva" id="pIva" maxlength="11"><span class="attention">*</span></input>
	<input type="hidden" name="type" value="impresa" />
EOF;
}

echo<<<EOF
	<br/>
	<label for="indirizzo">Indirizzo</label>
	<input type="text" name="indirizzo" id="indirizzo" maxlength="50"><span class="attention">*</span></input>
	<br/>
	<label for="citta">Città</label>
	<input type="text" name="citta" id="citta" maxlength="30"><span class="attention">*</span></input>
	<br/>
	<label for="telefono">Numero telefono</label>
	<input type="text" name="telefono" id="telefono" maxlength="11"><span class="attention">*</span></input>
	<br/>
EOF;


echo<<<EOF
	<br/>
	<br/>
	<input type="submit" value="Inserisci cliente" name="sendButton"/>
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;


printSectionEnd();
printPageEnd();
?>