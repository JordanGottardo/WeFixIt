<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Modifica fattura");
printMenu();
printSectionStart("Modifica i dati della fattura:");


$idFattura=$_POST["idFattura"];

$conn=connectDB();
$query="SELECT * FROM Fattura WHERE ID='$idFattura'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($result);


echo <<<EOF
<form action="confirmEditFattura.php" method="POST" name="formFattura" id="formFattura" onSubmit="return checkFattura();">
	<label for="idFattura">Fattura</label>
	<input type="hidden" id="idFattura" name="idFattura" value="$idFattura"/>$idFattura
	<br/>
	<label for="data">Data</label>
	<input type="text" name="data" id="data" value="$row[1]" maxlength="10"><span class="attention">*</span> (Formato AAAA-MM-GG)</input>
	<br/>
	<label for="imponibile">Imponibile</label>
	<input type="text" name="imponibile" id="imponibile" value="$row[2]" maxlength="10"><span class="attention">*</span></input>	
	<br/>
	<label for="aliquota">Aliquota</label>
	<input type="text" name="aliquota" id="aliquota" value="$row[3]" maxlength="5"><span class="attention">*</span> Formato NN,nn (ad es. 22,00)</input>	
	<br/>
	<label for="idIncarico">Incarico</label>
	<input type="hidden" id="idIncarico" name="idIncarico" value="$row[4]"/>$row[4]
	<br/>
	<input type="submit" value="Modifica fattura" name="sendButton"/>
</form>

</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;



printSectionEnd();
printPageEnd();
?>