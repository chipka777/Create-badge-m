<?php
include('../engine/functions.php');
if (isset($_POST['catName']) && $_POST['catName']!="") 
{
	$db = new Connection();
	$conn = $db->dbConnect();
	$st = $conn->prepare("insert into category values('','".$_POST['catName']."')");
	$st->execute();
	//header("Location: category.php?msg=added");
}
?>
<!DOCTYPE html>
<html>
<head>
<title></title>

<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<script src="//code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>


</head>
<a href="index.php">Main</a>
<?php
if(isset($_GET['msg']))
{
	echo "<h4>Category Added</h4>";
}
?>
<body>
	<?php if(!$_SESSION['user']) { 
	//header("Location: index.php");
	 } ?>
	<form method="POST" action=''>
		Add Category
		<br/>
		Category Name: <input type="text" name="catName" value='' placeholder='Category Name'/>
		<input type="submit" name="submitCat" value='Submit' />
	</form>
<table>
	<tr><th>ID</th><th>Category Name</th></tr>
	<?php
	$db = new Connection();
	$conn = $db->dbConnect();
	$st = $conn->prepare("SELECT * FROM category");
	$st->execute();
	$outputstring = "";
	while($tagscat = $st->fetch()) 
	{
		if($tagscat['cat_name']!=="")
		echo "<tr><td>".$tagscat['cat_id']."</td><td>".$tagscat['cat_name']."</td></tr>";
	}
	?>
</table>	
</body>
</html>