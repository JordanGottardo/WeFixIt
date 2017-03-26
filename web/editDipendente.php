<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Modifica dipendente");
printMenu();
printSectionStart("Modifica i dati del dipendente:");

$idDipendente=$_POST["idDipendente"];

$conn=connectDB();
$query="SELECT * FROM Dipendente WHERE ID='$idDipendente'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($result);

echo <<<EOF
<form action="confirmEditDipendente.php" method="POST" name="formDipendente" id="formDipendente" onSubmit="return checkDipendente();">
	<label for="idDipendente">Id</label>
	<input type="hidden" id="idDipendente" name="idDipendente" value="$idDipendente" >$idDipendente</input>
	<br/>
	<label for="nome">Nome</label>
	<input type="text" name="nome" id="nome" maxlength="50" value="$row[1]"><span class="attention">*</span></input>
	<br/>
	<label for="cognome">Cognome</label>
	<input type="text" name="cognome" id="cognome" maxlength="50" value="$row[2]"><span class="attention">*</span></input>	
	<br/>
	<label for="dataAssunzione">Data</label>
	<input type="text" name="dataAssunzione" id="dataAssunzione" maxlength="10" value="$row[3]"><span class="attention">*</span></input>	
	<br/>
	<input type="submit" value="Modifica dipendente" name="sendButton"/>
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;

printSectionEnd();
printPageEnd();


?>