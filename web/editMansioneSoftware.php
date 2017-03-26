<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Modifica mansione software");
printMenu();
printSectionStart("");

$conn=connectDB();
$idSoftware=$_POST["idMansione"];
//missing
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($result);

echo <<<EOF
<form action="confirmEditMansioneSoftware.php" method="POST" name="formSoftware" id="formSoftware" onSubmit="return checkSoftware();">
	<label for="idMansione">Id</label>
	<input type="text" name="idMansione" id="idMansione" value="$idMansione">$idMansione</input>
	<label for="descrizione">Descrizione</label>
	<input type="text" name="descrizione" id="descrizione value="$row[1]"><span class="attention">*</span></input>
	<br/>
	<label for="pOrario">Prezzo orario</label>
	<input type="text" name="pOrario" id="pOrario"><span class="attention value="$row[2]">*</span></input>	
	<br/>

</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
<div>

EOF;

printSectionEnd();
printPageEnd();

$conn=connectDB();

?>