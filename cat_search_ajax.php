<?php 
//include("header.php");
include("engine/functions.php");

$counter = 1;



$db = new Connection();
$conn = $db->dbConnect();
$_SESSION['search'] = $searchTerm = $_POST['search'];

if ($_POST['search']) {
	$query = "SELECT * FROM images WHERE approved = 1 AND MATCH(tags,name) AGAINST ('".$searchTerm."' IN BOOLEAN MODE)";
}
else {
	unset($_SESSION['search']);
	$cat=$_GET['id'];
	if($cat == '')
	{
		$query = 'SELECT * FROM images WHERE approved = 1 ORDER BY id DESC';
	}
	else
	{
		$query = 'SELECT * FROM images WHERE approved = 1 and category="'.$cat.'" ORDER BY id DESC';
	}
	
}
$st = $conn->prepare($query);
$st->execute();
$totalImages = $st->rowCount();
while ($img = $st->fetch()) {

	if ($counter < 10) {
		echo("<div id='img-".$img['id']."' class='panel pos".$counter."'><a href='preview.php?img=".$img['name']."'><img src='upload/".$img['name']."' /></a></div>");
		$counter ++;
	}
}

?>