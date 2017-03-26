<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Query 4 ");
printMenu();
printSectionStart("Totale e media del fatturato annuo");

$conn=connectDB();
$query="SELECT * FROM query4";
			  
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$intestazione=array("Anno", "Totale", "MediaFatturato");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	print_table_row($row);
}
print_table_end();

printSectionEnd();
printPageEnd();
?>