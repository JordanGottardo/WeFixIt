<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Elimina fattura");
printMenu();
printSectionStart("Conferma eliminazione fattura");

$idFattura=$_POST["idFattura"];

echo "<p>Eliminata fattura con Id: $idFattura";

$conn=connectDB();
$query="DELETE FROM Fattura WHERE ID='$idFattura'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));



printSectionEnd();
printPageEnd();
?>