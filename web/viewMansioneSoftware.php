<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Visualizza mansioni software");
printMenu();
printSectionStart("Lista mansioni software:");

$conn=connectDB();
$query="SELECT * FROM ClientePrivato";//da modificare
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$request = $_GET["request"];

echo "<form action='";

if ($request=="view")
	echo "deleteMansioneSoftware.php";
elseif ($request=="edit") 
	echo "editMansioneSoftware.php";
elseif ($request=="insertLavorazione")
	echo "insertLavorazione.php";

echo "' method=POST>";

$intestazione=array("", "ID", "Descrizione", "Prezzo orario");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
  $radio[0]="<input type=\"radio\" name=\"idMansione\" id=\"idMansione\" value=\"$row[0]\" />";
  print_table_row(array_merge($radio,$row));
}
print_table_end();

if ($request=="insertLavorazione")
{
	session_start();
	$idIncarico=$_SESSION["idIncarico"];
	echo<<<EOF
		<input type="hidden" name="idIncarico" id="idIncarico" value="$idIncarico" />
EOF;
}

echo "<br><input type=\"submit\" value='";

if($request=="view")
	echo "Elimina";
elseif ($request=="edit")
	echo "Modifica";
elseif ($request=="insertLavorazione")
	echo "Scegli mansione";


echo<<<EOF
>
</form>
EOF;

printSectionEnd();
printPageEnd();
?>