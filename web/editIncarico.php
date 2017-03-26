<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Modifica incarico");
printMenu();
printSectionStart("Modifica i dati dell'incarico:");


$conn=connectDB();
$idIncarico=$_POST["idIncarico"];
$query="SELECT * FROM Incarico WHERE ID='$idIncarico'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($result);


echo <<<EOF
<form action="confirmEditIncarico.php" method="POST" name="formIncarico" id="formIncarico" onSubmit="return checkIncarico();">
	<label for="idIncarico">Incarico</label>
	<input type="hidden" id="idIncarico" name="idIncarico" value="$idIncarico">$idIncarico</input>
	<br/>
	<label for="dataIni">Data inizio</label>
	<input type="text" name="dataIni" id="dataIni" value="$row[1]" maxlength="10"><span class="attention">*</span> (Formato AAAA-MM-GG)</input>
	<br/>
	<label for="dataFine">Data fine</label>
	<input type="text" name="dataFine" id="dataFine" value="$row[2]" maxlength="10"><span class="attention"></span> (Formato AAAA-MM-GG)</input>	
	<br/>
	<label for="cliente">Cliente</label>
	<input type="hidden" id="cliente" name="cliente" value="$row[3]">$row[3]</input>
	<br/>
	<input type="submit" value="Modifica incarico" name="sendButton"/>

</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;



printSectionEnd();
printPageEnd();
?>