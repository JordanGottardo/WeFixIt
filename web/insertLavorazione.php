<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Inserimento lavorazione");
printMenu();
printSectionStart("Inserisci lavorazione");

$idIncarico=$_POST["idIncarico"];
$idMansione=$_POST["idMansione"];
$idDipendente=$_POST["idDipendente"];

echo <<<EOF
<form action="confirmLavorazione.php" method="POST" name="formLavorazione" id="formLavorazione" onSubmit="return checkLavorazione();">
	<label for="idIncarico">Incarico</label>
	<input type="hidden" name="idIncarico" id="idIncarico" value="$idIncarico" >$idIncarico</input>
	<br/>
	<label for="idMansione">Mansione</label>
	<input type="hidden" name="idMansione" id="idMansione" value="$idMansione" >$idMansione</input>
	<br/>
	<label for="idDipendente">Dipendente</label>
	<input type="hidden" name="idDipendente" id="idDipendente" value="$idDipendente" >$idDipendente</input>
	<br/>
	<label for="dataIni">Data inizio</label>
	<input type="text" name="dataIni" id="dataIni" maxlength="10"><span class="attention">*</span> Formato AAAA-MM-GG</input>
	<br/>
	<label for="dataFine">Data fine</label>
	<input type="text" name="dataFine" id="dataFine" maxlength="10"><span class="attention">*</span> Formato AAAA-MM-GG</input>
	<br/>
	<label for="ore">Ore</label>
	<input type="text" name="ore" id="ore" maxlength="2"><span class="attention">*</span></input>
	<br/>
EOF;


$conn=connectDB();
$query="SELECT Tipo FROM Mansione WHERE ID='$idMansione'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row=mysqli_fetch_array($result);


if ($row[0]=='H')
{	
	echo<<<EOF
	<label for="quantitaHW">Quantità HW</label>
	<input type="text" name="quantitaHW" id="quantitaHW" maxlength="3"><span class="attention">*</span></input>
	<br/>
EOF;
}

echo<<<EOF
	<input type="submit" value="Inserisci lavorazione" name="sendButton"/>
	
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;

printSectionEnd();
printPageEnd();


?>

	