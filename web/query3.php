<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Query 3 ");
printMenu();
printSectionStart("Clienti che hanno richiesto almeno 1 incarico nel mese corrente");

$conn=connectDB();
$query="SELECT * FROM query3";
			  
			  
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$intestazione=array("IdCliente", "NumeroIncarichi");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	print_table_row($row);
}
print_table_end();

printSectionEnd();
printPageEnd();
?>