<?php 
session_start();

require("engine/functions.php");

	$lastID = $_SESSION['lastID'];
	$firstID = $_SESSION['firstID'];

	$currentID = $_POST['currentID'];
	$direction = $_POST['direction'];
	
	if ($_SESSION['search']) {
		$searchTerm = $_SESSION['search'];
		$searchQuery = "MATCH(tags,name) AGAINST ('".$searchTerm."' IN BOOLEAN MODE)";
	}
	else {
		$searchQuery = '';
	}
	
	if ($direction=='up') {
		// IF NEXT, GET NEXT RECORD IN TABLE AFTER ID (WHERE NEW > N LIMIT 1)
		if ($currentID==$lastID) {
			$query = "select * from images WHERE id = $firstID";
		}
		else {
			$query = "select * from images WHERE id = (select min(id) from images where id > ".$currentID.") ".$searchQuery;
		}
		$pos = 0;
	}
	else if ($direction=='down') {
		// IF PREV, GET PREV RECORD IN TABLE AFTER ID (WHERE NEW < N LIMIT 1)
		if ($currentID==$firstID) {
			$query = "select * from images WHERE id = $lastID";
		}
		else {
			$query = "select * from images WHERE id = (select max(id) from images where id < ".$currentID.") ".$searchQuery;
		}
		$pos = 9;
	}
	
	$db = new Connection();
	$conn = $db->dbConnect();
	$st = $conn->prepare($query);
	$st->execute();
	while ($img = $st->fetch()) {
	
		$_SESSION['currentID'] = $imgID = $img['id'];
		
		$panel = "<div id='img-".$img['id']."' class='panel pos".$pos."'><div class='caption'><h2>".$title."</h2><h3>".$tags."</h3></div><a href='preview.php?img=".$img['name']."'><img src='upload/".$img['name']."' /></a></div>";
		
			
	}
	
	
	

echo $panel;



?>