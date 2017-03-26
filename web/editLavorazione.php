<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Modifica lavorazione");
printMenu();
printSectionStart("Modifica i dati della lavorazione:");


$conn=connectDB();
$idLavorazione=$_POST["idLavorazione"];
$query="SELECT * FROM Lavorazione WHERE ID='$idLavorazione'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_row($result);


echo <<<EOF
<form action="confirmEditLavorazione.php" method="POST" name="formLavorazione" id="formLavorazione" onSubmit="return checkLavorazione();">
	<label for="idLavorazione">Lavorazione</label>
	<input type="hidden" id="idLavorazione" name="idLavorazione" value="$idLavorazione">$idLavorazione</input>
	<br/>
	<label for="dataIni">Data inizio</label>
	<input type="text" name="dataIni" id="dataIni" value="$row[1]" maxlength="10"><span class="attention">*</span> (Formato AAAA-MM-GG)</input>
	<br/>
	<label for="dataFine">Data fine</label>
	<input type="text" name="dataFine" id="dataFine" value="$row[2]" maxlength="10"><span class="attention">*</span> (Formato AAAA-MM-GG)</input>	
	<br/>
	<label for="ore">Ore</label>
	<input type="text" name="ore" id="ore" value="$row[3]" maxlength="2"><span class="attention">*</span></input>
	<br/>
EOF;

$conn=connectDB();
$query="SELECT M.Tipo FROM Lavorazione AS L JOIN Mansione AS M ON L.Mansione=M.ID WHERE L.ID='$idLavorazione'";
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
	<label for="idIncarico">Incarico</label>
	<input type="hidden" name="idIncarico" id="idIncarico" value="$row[6]">$row[6]</input>	
	<br/>
	<label for="idMansione">Mansione</label>
	<input type="hidden" name="idMansione" id="idMansione" value="$row[7]">$row[7]</input>	
	<br/>
	<label for="idDipendente">Dipendente</label>
	<input type="hidden" name="idDipendente" id="idDipendente" value="$row[8]">$row[8]</input>	
	<br/>
	<input type="submit" value="Modifica lavorazione" name="sendButton"/>
</form>

<div class="attention">
	<p>*Campo obbligatorio</p>
</div>

EOF;



printSectionEnd();
printPageEnd();
?>