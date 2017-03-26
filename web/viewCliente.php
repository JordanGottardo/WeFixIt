<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Visualizza clienti");
printMenu();
printSectionStart("Lista clienti:");

$conn=connectDB();
$query="SELECT * FROM Cliente";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));

$request = $_GET["request"];
$tipo=$_GET["type"];
echo "<form action='";


if($request=="view")
	echo "deleteCliente.php";
elseif ($request=="edit")
	echo "editCliente.php";
elseif ($request=="insIncarico")
	echo "insertIncarico.php";

echo "' method=POST>";

$intestazione=array("", "ID", "Tipo", "Nominativo", "Codice Fiscale", "Partita Iva", "Indirizzo", "Città","Telefono");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	if ((($row[1]=="P") && ($tipo=="privato")) || (($row[1]=="I") && ($tipo=="impresa")) || ($request=="insIncarico"))
	{
		$radio[0]="<input type=\"radio\" name=\"idCliente\" id=\"idCliente\" value=\"$row[0]\" checked />";
		print_table_row(array_merge($radio,$row));
	}
}
print_table_end();

echo<<<EOF
	<input type="hidden" name="type" value="$tipo" />
EOF;

echo "<br><input type=\"submit\" value='";

if($request=="view")
	echo "Elimina";
elseif ($request=="edit")
	echo "Modifica";
elseif ($request=="insIncarico")
	echo "Seleziona cliente";

echo<<<EOF
'>
</form>
EOF;

printSectionEnd();
printPageEnd();
?>