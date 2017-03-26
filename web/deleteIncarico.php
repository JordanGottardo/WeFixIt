<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Elimina incarico");
printMenu();
printSectionStart("Conferma eliminazione incarico");

$idIncarico=$_POST["idIncarico"];

echo "<p>Eliminato incarico con Id: $idIncarico";

$conn=connectDB();
$query="DELETE FROM Incarico WHERE ID='$idIncarico'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));



printSectionEnd();
printPageEnd();
?>