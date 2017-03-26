<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Elimina mansione");
printMenu();
printSectionStart("Conferma eliminazione mansione");

$idMansione=$_POST["idMansione"];

echo "<p>Eliminata mansione con Id: $idMansione";

$conn=connectDB();
$query="DELETE FROM Mansione WHERE ID='$idMansione'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));



printSectionEnd();
printPageEnd();
?>