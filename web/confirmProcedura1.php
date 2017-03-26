<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

printPageStart("Procedura 1 ");
printMenu();
printSectionStart(" Procedura che prende come input un valore ENUM(H, S, A) ad indicare un tipo di mansione o entrambe, una percentuale (negativa o positiva) espressa come decimale ed un valore limite anche’esso decimale. La procedura seleziona tutte le lavorazioni della tipologia fornita e calcola la media del loro costo. Se la percentuale fornita è negativa ed il risultato della media dei costi è minore del limite fornito allora il prezzo delle mansioni relative viene abbassato della percentuale fornita. Se la percentuale è positiva invece e la media maggiore del limite il prezzo viene aumentato della percentuale in input.
");

$tipo=$_POST["tipo"];
$percentuale=$_POST["percentuale"];
$limite=$_POST["limite"];




$query="CALL modPrezzoOrario('$tipo', '$percentuale', '$limite')";
$conn=connectDB();

$result=mysqli_query($conn, $query) or die(mysqli_error($conn));


echo<<<EOF
Hai modificato il prezzo delle mansioni di tipo $tipo aumentandone/diminuendone il prezzo di $percentuale tenendo conto del limite di $limite
EOF;


printSectionEnd();
printPageEnd();
?>


