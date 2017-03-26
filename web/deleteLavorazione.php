<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Elimina lavorazione");
printMenu();
printSectionStart("Conferma eliminazione lavorazione");

$idLavorazione=$_POST["idLavorazione"];

echo "<p>Eliminata lavorazione con Id: $idLavorazione";

$conn=connectDB();
$query="DELETE FROM Lavorazione WHERE ID='$idLavorazione'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));



printSectionEnd();
printPageEnd();
?>