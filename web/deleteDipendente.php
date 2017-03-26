<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Elimina dipendente");
printMenu();
printSectionStart("Conferma eliminazione dipendente");

$idDipendente=$_POST["idDipendente"];

echo "<p>Eliminato dipendente con Id: $idDipendente";

$conn=connectDB();
$query="DELETE FROM Dipendente WHERE ID='$idDipendente'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));



printSectionEnd();
printPageEnd();
?>