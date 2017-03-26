<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("functions.php");

session_start(); //Se già loggato, riporto alla home
if ($_SESSION['logged'])
	header("Location: index.php");

$username=$_POST['username'];
$password=$_POST['password'];

if ($username=="username" && $password=="password")
{
	$_SESSION['logged']="ProgettoDB1516";
	header("Location: index.php");
}
else //Login senza successo, stampo la form per il login
{
	printPageStart("Login");
	echo<<<EOF

	<form action="login.php" method="POST" id="login">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" />
		<label for="password">Password</label>
		<input type="text" name="password" id="password" />
		<input type="submit" value="Login" />
	</form>
EOF;
	if ($username || $password)
		echo "<p id=\"failedLogin\">Login fallito! Nome utente o password non corretti</p>";
	printPageEnd();
}