<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Visualizza incarichi");
printMenu();
printSectionStart("Lista incarichi:");



$request=$_GET["request"];
$query="SELECT * FROM Incarico";

echo "<form action='";

if($request=="view")
	echo "deleteIncarico.php";
elseif ($request=="edit")
	echo "editIncarico.php";
elseif ($request=="insertLavorazione")
{
	echo "viewMansione.php?request=insertLavorazione";
	$query="SELECT * FROM IncarichiNonTerminati";
}	
elseif ($request=="insFattura")
{
	echo "insertFattura.php";
	$query="SELECT * FROM IncarichiSenzaFattura";
}	
$conn=connectDB();

$result=mysqli_query($conn, $query) or die(mysqli_error($conn));
echo "' method=POST>";

$intestazione=array("", "ID", "Data inizio", "Data fine", "Cliente");
print_table_header($intestazione);
while ($row = mysqli_fetch_row($result)) 
{
	$radio[0]="<input type=\"radio\" name=\"idIncarico\" id=\"idIncarico\" value=\"$row[0]\" checked/>";
	print_table_row(array_merge($radio,$row));
}
print_table_end();
echo<<<EOF
	<input type="hidden" name="request" value="$request" />
EOF;
echo "<br><input type=\"submit\" value='";

if($request=="view")
	echo "Elimina";
elseif ($request=="edit")
	echo "Modifica";
elseif ($request=="insertLavorazione" || $request=="insFattura")
	echo "Scegli incarico";
	
echo<<<EOF
'>
</form>
EOF;

printSectionEnd();
printPageEnd();
?>