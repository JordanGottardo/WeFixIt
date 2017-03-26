<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Elimina clienti");
printMenu();
printSectionStart("Conferma eliminazione cliente");

$idCliente=$_POST["idCliente"];

echo "<p>Eliminato cliente con Id: $idCliente";

$conn=connectDB();
$query="DELETE FROM Cliente WHERE ID='$idCliente'";
$result=mysqli_query($conn, $query) or die(mysqli_error($conn));



printSectionEnd();
printPageEnd();
?>