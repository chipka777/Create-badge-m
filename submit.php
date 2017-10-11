<?php 
session_start();

include("engine/functions.php");

if ($_POST['submitImage']) {
	$name = $_POST['name'];
	$userID = $_SESSION['user'];
	$datetime = date('YYYY-mm-dd h:i:s');
	$tags = $_POST['tags'];
	$title = $_POST['title'];
	
	// PLUG INTO DATABASE
	$db = new Connection();
	$conn = $db->dbConnect();
	$st = $conn->prepare("INSERT INTO images VALUES ('','$name','$userID','$date','','$tags','$title','0')");
	$submitImage = $st->execute();
	
	if ($submitImage==true) {
		
		header("Location: index.php?m=uploadsuccess");
	}
	else {
		
		header("Location: index.php?m=uploadfail");
	}
}



?>