<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Query 7 ");
printMenu();
printSectionStart(" Dati degli incarichi che hanno richiesto ogni mansione esattamente una sola volta");

$conn=connectDB();

$query="SELECT * FROM query7";


$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$intestazione=array("IdIncarico", "DataInizio", "DataFine", "Cliente");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	print_table_row($row);
}
print_table_end();

printSectionEnd();
printPageEnd();
?>


