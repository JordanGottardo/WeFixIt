<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Visualizza imprese");
printMenu();
printSectionStart("Lista imprese:");

$conn=connectDB();
$query="SELECT * FROM ClientePrivato";//da modificare
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$request = $_GET["request"];

echo "<form action='";

if($request=="view")
  echo "deleteImpresa.php";
else  echo "editImpresa.php";

echo "' method=POST>";

$intestazione=array("", "ID", "Ragione sociale", "Partita Iva", "Indirizzo","Telefono");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
  $radio[0]="<input type=\"radio\" name=\"idImpresa\" id=\"idImpresa\" value=\"$row[0]\" />";
  print_table_row(array_merge($radio,$row));
}
print_table_end();

echo "<br><input type=\"submit\" value='";

if($request=="view")
	echo "Elimina";
else
	echo "Modifica";

echo<<<EOF
>
</form>
EOF;

printSectionEnd();
printPageEnd();
?>