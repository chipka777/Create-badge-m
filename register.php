<?php 
session_start();
require("engine/functions.php");

$email = $_POST['email'];

$pass = $_POST['password'];

$username = $_POST['username'];

$db = new Connection();
$conn = $db->dbConnect();
$st = $conn->prepare("INSERT INTO users VALUES ('', ?, ?, ?)");
$st->bindParam(1,$username);
$st->bindParam(2,$email);
$st->bindParam(3,$pass);
$registered = $st->execute();

if ($registered) {
	sendMail($email, "Thank you for registering with Badge'M!","Thank you for your registration! You can now log in and upload to the Badgem Universe! Your username is $username and your password is $pass. if there is an issue");

	header("Location: index.php?m=regsuccess");
}
else {
	header("Location: index.php?m=regerror");
}




?>