<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Query 6 ");
printMenu();
printSectionStart("ID degli incarichi nei quali uno o più dipendenti hanno partecipato lavorando in totale più di 100 ore ed in cui le lavorazioni prese in considerazione siano iniziate non oltre un anno fa a partire dalla data corrente, per ogni ID vengono visualizzati nome e cognome dei dipendenti che soddisfano il vincolo");

$conn=connectDB();

$query="SELECT * FROM query9";


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


