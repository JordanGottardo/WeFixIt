<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Visualizza abilitazioni");
printMenu();
printSectionStart("Lista abilitazioni:");

$conn=connectDB();
$query="SELECT * FROM Abilitazione";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$request=$_GET["request"];

echo "<form action='";



echo "' method=POST>";

$intestazione=array("Dipendente", "Mansione", "Data inizio");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	print_table_row(array_merge($row));
}
print_table_end();
	
echo<<<EOF
</form>
EOF;

printSectionEnd();
printPageEnd();
?>