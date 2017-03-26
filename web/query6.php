<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Query 6 ");
printMenu();
printSectionStart("ID e nominativo dei clienti privati per i quali sono state emesse più di 2 fatture che abbiano un imponibile medio maggiore di 500 euro ma che non contengano mansioni che siano state eseguite all’iterno di un incarico richiesto da un’impresa e non ancora terminato.
");

$conn=connectDB();

$query="SELECT * FROM query6";


$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$intestazione=array("IdCliente", "Nominativo", "MediaFatture");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	print_table_row($row);
}
print_table_end();

printSectionEnd();
printPageEnd();
?>


