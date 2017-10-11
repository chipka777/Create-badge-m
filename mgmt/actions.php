<?php 

include('../engine/functions.php');

if ($_GET['action']=='delete') {

$imgID = $_GET['id'];

$db = new Connection();
$conn = $db->dbConnect();
$st = $conn->prepare("DELETE FROM images WHERE id = '$imgID'");
$st->execute();

header("Location: index.php?msg=deleted");

}

if ($_GET['action']=='approve') {

$imgID = $_GET['id'];

$db = new Connection();
$conn = $db->dbConnect();
$st = $conn->prepare("UPDATE images SET approved = 1 WHERE id = '$imgID'");
$st->execute();

header("Location: index.php?msg=approved");

}

if ($_GET['action']=='invisible') {

$imgID = $_GET['id'];

$db = new Connection();
$conn = $db->dbConnect();
$st = $conn->prepare("UPDATE images SET approved = 0 WHERE id = '$imgID'");
$st->execute();

header("Location: index.php?msg=invisible");

}
if (isset($_POST['actionFun']) && $_POST['actionFun']=='approveAll') {

	$imgIDs = $_POST['actionIDs'];
	$imgIDs =  trim($imgIDs,",");
	if($imgIDs!=="")
	{
		$db = new Connection();
		$conn = $db->dbConnect();
		$st = $conn->prepare("UPDATE images SET approved = 1 WHERE id  IN (".$imgIDs.")");
		$st->execute();
	}	

	echo "index.php?msg=approved";

}

if (isset($_POST['actionFun']) && $_POST['actionFun']=='invisibleAll') {

	$imgIDs = $_POST['actionIDs'];
	$imgIDs =  trim($imgIDs,",");
	if($imgIDs!=="")
	{
		$db = new Connection();
		$conn = $db->dbConnect();
		$st = $conn->prepare("UPDATE images SET approved = 0 WHERE id  IN (".$imgIDs.")");
		$st->execute();
	}	

	echo "index.php?msg=invisible";

}
if (isset($_POST['actionCategories']) && $_POST['actionCategories']!='') {

	$imgIDs = $_POST['actionIDs'];
	$imgIDs =  trim($imgIDs,",");
	if($imgIDs!=="")
	{
		$db = new Connection();
		$conn = $db->dbConnect();
		$st = $conn->prepare("UPDATE images SET category = '".$_POST['actionCategories']."' WHERE id  IN (".$imgIDs.")");
		$st->execute();
	}	

	echo "index.php?msg=setCategory";

}


if ($_GET['action']=='search')
{
	
$db = new Connection();
$conn = $db->dbConnect();
if($_GET['id'] == ''){
	
	$st = $conn->prepare("SELECT * FROM images WHERE approved != 2 ORDER BY id DESC");
}
else{
	$st = $conn->prepare("SELECT * FROM images WHERE approved != 2 and category = '".$_GET['id']."' ORDER BY id DESC");
}
$st->execute();
$setupNot = "";

if($st->rowCount() > 0){
	
	while($img = $st->fetch()) {
if($img['approved']==0) {
$approved = '<div class="waiting">NEW</div>';
$setupNot = "<a class='approve' href='actions.php?id=".$img['id']."&action=approve'>Approve</a>";
}
else{
$approved = '';
$setupNot = "<a class='approve' href='actions.php?id=".$img['id']."&action=invisible'>Invisible</a>";
}
$image = "http://create.badge-m.com/upload/".$img['name'];
echo "<div class='img'><input type='checkbox' value='".$img['id']."' class='checkItem' name='imgAll[]'/>".$approved."<div class='btns'>".$setupNot."<a class='delete' href='actions.php?id=".$img['id']."&action=delete'>Delete</a></div><img src='".$image."' /></div>";
}
}
else{
	
		echo "Result not found try again !!";
		
	}


}
?>