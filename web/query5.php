<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Query 5 ");
printMenu();
printSectionStart(" ID e data d’inizio degli incarichi nei quali sono state eseguite almeno una lavorazione software e due lavorazioni hardware per le quali, in tutto, siano stati utilizzati più di 50 pezzi ");

$conn=connectDB();
$query="SELECT * FROM query5";
			  
			  
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$intestazione=array("IdIncarico", "DataInizio", "TotalePezzi");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	print_table_row($row);
}
print_table_end();

printSectionEnd();
printPageEnd();
?>

						