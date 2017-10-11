<?php 
session_start();
require("engine/functions.php");

if ($_POST['login']) {

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$DB = new Connection();
	$DB = $DB->dbConnect();
	$st = $DB->prepare("SELECT * FROM users WHERE name = '$username' AND password = '$password'");
	$login = $st->execute();
	while ($user = $st->fetch()) {
		$userID = $user['id'];
		$name = $user['name'];
	}
	
	if ($login) {
		$_SESSION['user'] = $userID;
		$_SESSION['name'] = $name;
		header("Location: index.php");
	}
	else {
		header("Location: index.php?e=invalid");
	}
}

?>