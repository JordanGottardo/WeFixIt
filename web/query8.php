<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Query 8 ");
printMenu();
printSectionStart("Totale delle fatture emesse per incarichi che comprendono lavorazioni che sono state terminate oltre una settimana dopo la data di inizio incarico");

$conn=connectDB();

$query="SELECT * FROM query8";


$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$intestazione=array("Totale");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	print_table_row($row);
}
print_table_end();

printSectionEnd();
printPageEnd();
?>


