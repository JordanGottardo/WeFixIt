<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Elimina mansione software");
printMenu();
printSectionStart("Conferma eliminazione mansione software");

$idMansione=$_POST["idMansione"];

echo "<p>Eliminata mansione software con Id: $idMansione";

$conn=connectDB();
//missing
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));



printSectionEnd();
printPageEnd();
?>