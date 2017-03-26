<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Visualizza lavorazione");
printMenu();
printSectionStart("Lista lavorazioni:");

$conn=connectDB();
$query="SELECT * FROM Lavorazione";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$request=$_GET["request"];

echo "<form action='";

if($request=="view")
	echo "deleteLavorazione.php";
else
	echo "editLavorazione.php";

echo "' method=POST>";

$intestazione=array("", "ID", "Data Inizio", "Data fine ", "Ore", "Costo", "Quantità HW", "Incarico", "Mansione", "Dipendente");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	$radio[0]="<input type=\"radio\" name=\"idLavorazione\" id=\"idLavorazione\" value=\"$row[0]\" checked/>";
	print_table_row(array_merge($radio,$row));
}
print_table_end();

echo "<br><input type=\"submit\" value='";

if($request=="view")
	echo "Elimina";
elseif ($request=="edit")
	echo "Modifica";
	
echo<<<EOF
'>
</form>
EOF;

printSectionEnd();
printPageEnd();
?>