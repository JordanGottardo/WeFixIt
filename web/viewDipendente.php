<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Visualizza dipendenti");
printMenu();
printSectionStart("Lista dipendenti:");

$conn=connectDB();
$query="SELECT * FROM Dipendente";

$request=$_GET["request"];
echo "<form action='";

if ($request=="view")
	echo "deleteDipendente.php";
elseif ($request=="edit")
	echo "editDipendente.php";
elseif ($request=="insAbilitazione")
	echo "viewMansione.php?request=insAbilitazione";
elseif ($request=="insertLavorazione")
	echo "insertLavorazione.php";

echo "' method=POST>";


if ($request=="insertLavorazione")
{
	$idMansione=$_POST["idMansione"];
	$idIncarico=$_POST["idIncarico"];
	$query="SELECT D.ID, D.Nome, D.Cognome, D.DataAssunzione FROM Dipendente as D JOIN Abilitazione as A ON D.ID=A.Dipendente, Incarico AS I
	WHERE A.Mansione='$idMansione' AND I.DataInizio>=A.DataInizio AND I.ID='$idIncarico'"; 
}
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$intestazione=array("", "ID", "Nome", "Cognome", "Data assunzione");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	$radio[0]="<input type=\"radio\" name=\"idDipendente\" id=\"idDipendente\" value=\"$row[0]\" checked />";
	print_table_row(array_merge($radio,$row));
}
print_table_end();

if ($request="insertLavorazione")
{
echo<<<EOF
	<input type="hidden" name="idIncarico" id="idIncarico" value="$idIncarico" />
	<input type="hidden" name="idMansione" id="idMansione" value="$idMansione" />
EOF;
}
echo "<br><input type=\"submit\" value='";

if($request=="view")
	echo "Elimina";
elseif ($request=="edit")
	echo "Modifica";
elseif ($request=="insAbilitazione" || $request="insertLavorazione")
	echo "Scegli dipendente";
		
echo<<<EOF
'>
</form>
EOF;

printSectionEnd();
printPageEnd();
?>