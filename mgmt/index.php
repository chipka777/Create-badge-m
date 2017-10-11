<?php 
session_start();
include("../engine/functions.php");

if ($_POST['submit']) {

	if($_POST['pass']=='BooBoo888') {
	$_SESSION['user'] = 1;
	header("Location: index.php");
	}

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

<script>
$(document).ready(function(){
	$(".checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });
})
function getAction(actionValue)
{
	var selected = '';
	$('.checkItem:checked').each(function() {
		selected += $(this).val()+",";
	});
	if(selected=='')
	{
		alert("Please select Image");
	}
	else
	{
		$.ajax({
			url: "actions.php",
			type:"POST",
			data: {actionIDs : selected,actionFun:actionValue},
			success: function(html){
				window.location.href = html; 
			}
		});
	}
}
function getCate(actionValue)
{
	var selected = '';
	$('.checkItem:checked').each(function() {
		selected += $(this).val()+",";
	});
	if(selected=='')
	{
		alert("Please select Image");
	}
	else
	{
		$.ajax({
			url: "actions.php",
			type:"POST",
			data: {actionIDs : selected,actionCategories:actionValue},
			success: function(html){
				window.location.href = html; 
			}
		});
	}
}
function searchCate(actionValue)
{
	
		$('.feed').html('<img style="margin: 62px;width: 50px;" src="/img/ajax-loader.gif" />'); 
		$.ajax({
			url: "actions.php?action=search&id="+actionValue,
			type:"POST",
			success: function(html){
				$('.feed').html(html); 
			}
		});
	
}
</script>
</head>
<body>

<?php if(!$_SESSION['user']) { ?>
<form method="POST" action=''>
Login:<br>
<input type="text" name="pass" value='' placeholder='Password'/>
<input type="submit" name="submit" value='Enter' />
</form>
<?php } else { ?>
<?php if ($_GET['msg']) {
if ($_GET['msg']=='approved') { $message = 'Image has been approved'; }
else if ($_GET['msg']=='deleted') { $message = 'Image has been deleted'; }
else if ($_GET['msg']=='invisible') { $message = 'Image has been Invisible'; }
else if ($_GET['msg']=='setCategory') { $message = 'Image Category updated'; }
echo "<div class='message'>".$message."</div>";
}?>
<input type="checkbox" class="checkAll">Select All
<select name="forma" onchange="getAction(this.value);">
 <option value="">Select Action</option>
 <option value="approveAll">Approve</option>
 <option value="invisibleAll">Invisible</option>
 
</select>
Category

<select name="catSelector" onchange="getCate(this.value);">
<option value="">Select Category</option>
<?php catTags();?>
</select>
<a href="category.php">Add Category</a>

<br />
<br />
Search
<select name="searchCate" onchange="searchCate(this.value);">
 <option value="">Select Category</option>
<?php catTags();?>
</select>

<div class='feed'><?php adminFeed(); ?></div>

<?php } ?>

</body>
</html>