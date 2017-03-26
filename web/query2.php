<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Query 2 ");
printMenu();
printSectionStart("Lista di tutte le mansioni eseguite con i rispettivi incarichi e le relative fatture
");

$conn=connectDB();
$query="SELECT * FROM query2";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$intestazione=array("IdMansione", "Descrizione", "IdFattura");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	print_table_row($row);
}
print_table_end();

printSectionEnd();
printPageEnd();
?>