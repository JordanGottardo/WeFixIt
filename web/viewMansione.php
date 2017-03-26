<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Visualizza mansioni ");
printMenu();
printSectionStart("Lista mansioni:");

$request = $_GET["request"];
$conn=connectDB();
$query="SELECT * FROM Mansione";

if ($request=="insAbilitazione")
{
	$idDipendente=$_POST["idDipendente"];
	$query="SELECT *
FROM Mansione
WHERE ID NOT IN(
								SELECT A.Mansione
								FROM Dipendente AS D JOIN Abilitazione AS A on D.ID=A.Dipendente
								WHERE D.ID='$idDipendente'
							)";
}
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));


$tipo=$_GET["type"];
echo "<form action='";

if($request=="view")
  echo "deleteMansione.php";
elseif ($request=="edit") 
	echo "editMansione.php";
elseif ($request=="insertLavorazione")
	echo "viewDipendente.php?request=insertLavorazione";
elseif ($request=="insAbilitazione")
	echo "insertAbilitazione.php";

echo "' method=POST>";

$intestazione=array("", "ID", "Tipo", "Descrizione", "Prezzo orario", "Costo hardware");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	if (($tipo=="software" && $row[1]=="S") || ($tipo=="hardware" && $row[1]=="H") || ($request=="insAbilitazione") || ($request=="insertLavorazione"))
	{
		$radio[0]="<input type=\"radio\" name=\"idMansione\" id=\"idMansione\" value=\"$row[0]\" checked />";
		print_table_row(array_merge($radio,$row));
	}
}
print_table_end();

echo<<<EOF
	<input type="hidden" name="type" id="type" value="$tipo" />
EOF;

if ($request=="insertLavorazione")
{
	$idIncarico=$_POST["idIncarico"];
	echo<<<EOF
		<input type="hidden" name="idIncarico" id="idIncarico" value="$idIncarico" />
EOF;
}
elseif ($request=="insAbilitazione")
{
	echo<<<EOF
		<input type="hidden" name="idDipendente" id="idDipendente" value="$idDipendente" />
EOF;
}

echo "<br><input type=\"submit\" value='";

if($request=="view")
	echo "Elimina";
elseif ($request=="edit")
	echo "Modifica";
elseif ($request=="insertLavorazione" || $request=="insAbilitazione")
	echo "Scegli mansione";

echo<<<EOF
'>
</form>
EOF;

printSectionEnd();
printPageEnd();
?>