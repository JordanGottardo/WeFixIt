<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Modifica mansione");
printMenu();
printSectionStart("");


$idMansione=$_POST["idMansione"];
$tipo=$_POST["type"];
$conn=connectDB();
$query="SELECT * FROM Mansione WHERE ID='$idMansione'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($result);

if ($tipo=="software")
{
	echo<<<EOF
		<form action="confirmEditMansione.php" method="POST" name="formMansione" id="formMansione" onSubmit="return checkSoftware();">
EOF;
}
elseif ($tipo=="hardware")
{
	echo<<<EOF
		<form action="confirmEditMansione.php" method="POST" name="formMansione" id="formMansione" onSubmit="return checkHardware();">
EOF;
}

echo <<<EOF
	<label for="idMansione">Id</label>
	<input type="hidden" name="idMansione" id="idMansione" value="$idMansione" >$idMansione</input>
	<br/>
	<label for="tipo">Tipo</label>
	<input type="hidden" name="type" id="type" value="$row[1]">$row[1]</input>
	<br/>
	<label for="descrizione">Descrizione</label>
	<input type="text" name="descrizione" id="descrizione" value="$row[2]" maxlength="50"><span class="attention">*</span></input>
	<br/>
	<label for="prezzo">Prezzo orario</label>
	<input type="text" name="prezzo" id="prezzo" value="$row[3]" maxlength="13"><span class="attention">*</span></input>	
	<br/>
	
EOF;

if ($tipo=="hardware")
{
	echo<<<EOF
	<label for="CostoHW">Costo hardware</label>
	<input type="text" name="costoHW" id="costoHW" maxlength="13" value="$row[4]"><span class="attention">*</span></input>	
	<br/>
EOF;
}

echo<<<EOF
	<input type="submit" value="Modifica mansione" name="sendButton"/>
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;

printSectionEnd();
printPageEnd();


?>