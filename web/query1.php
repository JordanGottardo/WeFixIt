<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Query 1 ");
printMenu();
printSectionStart("Lista dei clienti con incarichi in corso");

$conn=connectDB();
$query="SELECT * FROM query1";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$intestazione=array("IdCliente", "Nominativo", "IdIncarico", "DataInizio");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	print_table_row($row);
}
print_table_end();

printSectionEnd();
printPageEnd();
?>