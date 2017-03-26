<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Funzione 2 ");
printMenu();
printSectionStart("Funzione che riceve in input due decimali ed un booleano. Se il booleano è false ritorna la lista degli incarichi per cui è stata emessa una fattura con imponibile compreso tra i due valori forniti, se il booleano è true la verifica dei limiti è fatta tenendo conto anche dell’aliquota.
");

$X=$_POST["X"];
$Y=$_POST["Y"];
$IVA=$_POST["IVA"];

if ($IVA=="check")
	$IVA=1;
else
	$IVA=0;

$query="SELECT F.ID, findFattura(F.ID, '$X', '$Y', '$IVA') AS Totale
			 FROM Fattura AS F
			 HAVING Totale>0";
$conn=connectDB();

$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

echo "<form action='";
echo "' method=POST>";

$intestazione=array("IdFattura","Totale");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	print_table_row($row);
}
print_table_end();

printSectionEnd();
printPageEnd();
?>


