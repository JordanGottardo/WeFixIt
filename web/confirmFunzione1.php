<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Funzione 1 ");
printMenu();
printSectionStart("Funzione che prende in input una città e restituisce la quantità di lavorazioni eseguite da ogni dipendente per clienti che risiedono nella città indicata 
");

$citta=$_POST["citta"];

echo<<<EOF
<br>
Hai scelto come città: $citta
EOF;

$query="SELECT ID, lavorazioniDipCitta('$citta')
			  FROM Dipendente";

$conn=connectDB();

$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

echo "<form action='";
echo "' method=POST>";

$intestazione=array("IdDipendente","NumLavorazioni");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	print_table_row($row);
}
print_table_end();

printSectionEnd();
printPageEnd();
?>


