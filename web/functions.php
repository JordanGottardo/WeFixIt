<?php

function printPageStart($title) 
{
	echo<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
	<title>Titolo</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<script type="text/javascript" src="javascript/script.js"></script>
</head>
<body>
	<div id="header">
		<span>Progetto Basi di Dati 2015/2016 - Jordan Gottardo & Giovanni Prete - WeFixIt</span>
	</div>	
	<div id="title">
		<h1>$title</h1>
	</div>
EOF;
}

function printSectionStart($text)
{
	echo<<<EOF
		<div id="section">
			<p id="description">$text</p>
EOF;
}

function printSectionEnd()
{
	echo<<<EOF
	</div>
EOF;
}

function printMenu()
{
	checkLogin() or die("Accesso negato. Effettuare il <a href=\"login.php\">login</a>");
	
	echo<<<EOF
	<div id="menu">
		<span id="logout"><a href="logout.php">Logout</a></span>
		<span id="menuSpan">Menu</span>
		<ul id="topMenuList">
			<li>Clienti privati</li>
			<ul class="midMenuList">
				<li><a href="insertCliente.php?type=privato">Inserisci</a></li>
				<li><a href="viewCliente.php?type=privato&request=edit">Modifica</a></li>
				<li><a href="viewCliente.php?type=privato&request=view">Visualizza</a></li>
			</ul>
			<li>Imprese</li>
			<ul class="midMenuList">
				<li><a href="insertCliente.php?type=impresa">Inserisci</a></li>
				<li><a href="viewCliente.php?type=impresa&request=edit">Modifica</a></li>
				<li><a href="viewCliente.php?type=impresa&request=view">Visualizza</a></li>
			</ul>
			<li>Incarichi</li>
			<ul class="midMenuList">
				<li><a href="viewCliente.php?request=insIncarico">Inserisci</a></li>
				<li><a href="viewIncarico.php?request=edit">Modifica</a></li>
				<li><a href="viewIncarico.php?request=view">Visualizza</a></li>
			</ul>
			<li>Fatture</li>
			<ul class="midMenuList">
				<li><a href="viewIncarico.php?request=insFattura">Inserisci</a></li>
				<li><a href="viewFattura.php?request=edit">Modifica</a></li>
				<li><a href="viewFattura.php?request=view">Visualizza</a></li>
			</ul>
			<li>Lavorazioni</li>
			<ul class="midMenuList">
				<li><a href="viewIncarico.php?request=insertLavorazione">Inserisci</a></li>
				<li><a href="viewLavorazione.php?request=edit">Modifica</a></li>
				<li><a href="viewLavorazione.php?request=view">Visualizza</a></li>
			</ul>
			<li>Software</li>
			<ul class="midMenuList">
				<li><a href="insertMansione.php?type=software">Inserisci</a></li>
				<li><a href="viewMansione.php?type=software&request=edit">Modifica</a></li>
				<li><a href="viewMansione.php?type=software&request=view">Visualizza</a></li>
			</ul>			
			<li>Hardware</li>
			<ul class="midMenuList">
				<li><a href="insertMansione.php?type=hardware">Inserisci</a></li>
				<li><a href="viewMansione.php?type=hardware&request=edit">Modifica</a></li>
				<li><a href="viewMansione.php?type=hardware&request=view">Visualizza</a></li>
			</ul>			
			<li>Dipendenti</li>
			<ul class="midMenuList">
				<li><a href="insertDipendente.php">Inserisci</a></li>
				<li><a href="viewDipendente.php?request=edit">Modifica</a></li>
				<li><a href="viewDipendente.php?request=view">Visualizza</a></li>
			</ul>			
			<li>Abilitazioni</li>
			<ul class="midMenuList">
				<li><a href="viewDipendente.php?request=insAbilitazione">Inserisci</a></li>
				<li><a href="viewAbilitazione.php?request=view">Visualizza</a></li>
			</ul>			
			<li>Query</li>
			<ul class="midMenuList">
				<li><a href="query1.php">Query 1</a></li>
				<li><a href="query2.php">Query 2</a></li>
				<li><a href="query3.php">Query 3</a></li>
				<li><a href="query4.php">Query 4</a></li>
				<li><a href="query5.php">Query 5</a></li>
				<li><a href="query6.php">Query 6</a></li>
				<li><a href="query7.php">Query 7</a></li>
				<li><a href="query8.php">Query 8</a></li>
				<li><a href="query9.php">Query 9</a></li>
			</ul>
			<li>Funzioni</li>
			<ul class="midMenuList">
				<li><a href="funzione1.php">Funzione 1</a></li>
				<li><a href="funzione2.php">Funzione 2</a></li>
				<li><a href="procedura1.php">Procedura 1</a></li>
			</ul>
		</ul>
	</div>
EOF;
}

function printPageEnd()
{
	echo<<<EOF
</body>
</html>
EOF;
}


function checkLogin()
{
	session_start();
	if ($_SESSION['logged'])
		return TRUE;
	else
		return FALSE;
}


//Connessione

function dbConnect($name)
{

  $server="basidati.studenti.math.unipd.it";
  $username="jgottard";
  $password='2AU4YkmC';
  
  $conn=mysqli_connect($server,$username,$password) or die("Impossibile connettersi!");

  mysqli_select_db($conn,$name);

  return $conn;
//
}


function connectDB()
{
  $conn=dbConnect("jgottard-PR");
  return $conn;
}


// stampare tabella

function print_table_header($row)
{
	echo<<<EOF
	<table>
		<tr>
EOF;

	foreach ($row as $field)
		echo "<th>$field</th>\n";
		echo"</tr>\n";
}


function print_table_row($row)
{
	echo "<tr>\n";
	foreach ($row as $field)
		if ($field)
			echo "<td>$field</td>\n";
		else
			echo "<td>---</td>\n";
		echo "</tr>\n";
}

function print_table_end()
{
	echo "</table>\n";
}

?>