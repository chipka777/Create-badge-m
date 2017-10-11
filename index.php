<?php include("header.php");
include("engine/functions.php");

if (!$_POST['search']) {
	unset($_SESSION['search']);
}

// GET TOTAL NUMBER OF ROWS IN IMAGE TABLE
$db = new Connection();
$conn = $db->dbConnect();
$st = $conn->prepare("SELECT * FROM images");
$st->execute();
$totalImg = $st->rowCount();

// GET ID OF FIRST RECORD, AND ID OF LAST RECORD
$db = new Connection();
$conn = $db->dbConnect();
$st = $conn->prepare("SELECT * FROM images ORDER BY id DESC LIMIT 1");
$st->execute();
while ($last = $st->fetch()) {
	$_SESSION['lastID'] = $lastID = $last['id'];
}

$db = new Connection();
$conn = $db->dbConnect();
$st = $conn->prepare("SELECT * FROM images ORDER BY id ASC LIMIT 1");
$st->execute();
while ($last = $st->fetch()) {
	$_SESSION['firstID'] = $firstID = $last['id'];
}

if (!$_SESSION['currentID']) {
	$_SESSION['currentID'] = $lastID;
}

?>
<div id="file-modal">
	<div class="file-close">x</div>
	<div class="upload-form-wrap">
		<h3>Upload a File to the Badge'M Universe!</h3>
	   <form id="upload-form" action="preview.php" method="post" enctype="multipart/form-data">
	   	<input type="file" name="photo" size="25" />
	   	<input type="submit" name="submit" value="Upload!" />
	   </form>
	    
	</div>
</div>


<div id="file-modal-search">
	<div class="file-close-search">x</div>
	<div class="upload-form-wrap">
		<h3>Category Search !</h3>
	   <select name="searchCate" onchange="searchCate(this.value);">
 <option value="">Select Category</option>
<?php catTags();?>
</select>
	    
	</div>
</div>

<!-- popup main -->

<div class="main">

	<div class="head-t">
	<img class="dash-logo" src="img/badgem-bwlogo1.png" />
	
	<div class="navigation">
		<img src="img/feed1.png" id="feed" class="active" onclick="getFeed()"/>
		<img src="img/instagram1.png" id="insta" onclick="getInsta()"/>
		<img src="img/shop1.png" id="shop">
	</div>
	</div>
	<div class="nav-panels">
		<div id="feed-panel" class="nav-panel show">
			<form id="search-form" method="post" action="">
			<!--<input type="text" name="search" value="" placeholder="Search badges!" />
			<input type="submit" name="submit" value="Search!" />-->
			<div class="output">
			<?php if ($_SESSION['search']) { 
				echo("Search: ".$_SESSION['search']);
				echo("<br>");
				echo("<a href='index.php'>Clear Search</a>");
			 }?><!-- error or success results --></div>
			</form>
			<div class="mid-sec-custm">
			<ul>
			<li class="">
			<div class="file-btn-search">
			<label><a href="javascript:void(0)"><img src="img/img1.png"></a></label>
			</div>
			</li>
			<li class="">
			<div class="">
			<label><a href=""><img src="img/img2.png"></a></label></div>
			</li>
			<li class="">
			<div class="">
			<label><a href=""><img src="img/img3.png"></a></label>
			</div>
			</li>
			<li class="">
			<div class="" page-value="1" >
			<label><button class="prev" page-value="1"><img src="img/img4.png"></button></label>
			</div>
			</li>
			<li class="">
			<div class="">
			<label><button class="file-btn"><img src="img/img5.png"></button></label>
			</div>
			</li>
			<li class="">
			<div class="" page-value="1">
			<label><button class="next" page-value="1"><img src="img/img6.png"></button></label>
			</div>
			</li>
			</ul>
						</div>
			
		</div>
		
	</div>

</div><!-- END MAIN --> 

<div class="panels">
<?php 
$counter = 1;



$db = new Connection();
$conn = $db->dbConnect();
$_SESSION['search'] = $searchTerm = $_POST['search'];

echo $searchTerm;
if ($_POST['search']) {
	$query = "SELECT * FROM images WHERE approved = 1 AND MATCH(tags,name) AGAINST ('".$searchTerm."' IN BOOLEAN MODE)";
}
else {
	
	unset($_SESSION['search']);
	$query = 'SELECT * FROM images WHERE approved = 1 ORDER BY id DESC';
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

</div>
<script>

$(document).ready(function () 
{

	$(".next").click(function () 
	{
		var feedType = $(".navigation .active").attr('id');
		if(feedType=="feed")
		{
			nextFeedClick();
			
		}
        else if(feedType=="insta")	
		{
			nextInstaClick();
		}		
	});
	
	$(".prev").click(function () 
	{
		var feedType = $(".navigation .active").attr('id');
		if(feedType=="feed")
		{		
			prevFeedClick();
		}
		else if(feedType=="insta")
        {
			prevInstaClick();
		}			
	});
	
});
function nextInstaClick()
{
		var totalimages = $(".panel").length;
		for (i = 1; i < totalimages; i++) 
		{ 
			if(i<=10)
			{
				$(".panels .panel:nth-child("+(i+1)+")").addClass("pos"+(i-1)+" show_image").removeClass("pos"+(i)+" hide_image");
			}	
			else 
			{
				$(".panels .panel:nth-child("+(i+1)+")").addClass("pos"+(i-1)+" hide_image").removeClass("pos"+(i)+" show_image");
			}	
			var temp =  totalimages-1;
			if(i==temp)
			{
				$(".panels .panel:first-child").addClass("pos"+(totalimages-1)+"").removeClass("pos0");
				$('.panels .panel:first').appendTo('.panels');
				$( ".panel" ).last().addClass( "hide_image" ).removeClass("show_image");;
			}
		}
		
}
function prevInstaClick()
{
		var totalimages = $(".panel").length;
		for (i = 1; i < totalimages; i++) 
		{ 
			if(i<=9)
			{
					$(".panels .panel:nth-child("+i+")").addClass("pos"+i+" show_image").removeClass("pos"+(i-1)+" hide_image");
			}	
			else 
			{
					$(".panels .panel:nth-child("+i+")").addClass("pos"+i+" hide_image").removeClass("pos"+(i-1)+" show_image");
			}	
			var temp =  totalimages-1;
			if(i==temp)
			{
				$(".panels .panel:last-child").addClass("pos0 show_image").removeClass("pos"+(totalimages-1)+"");
				$('.panels .panel:last').prependTo('.panels');
				//$( ".panel" ).first().addClass( "show_image").removeClass("hide_image");;
			}
		}
}
function prevFeedClick()
{
		var total = <?php echo $totalImages; ?>;
	var firstImg = <?php echo $firstID; ?>;
	var lastImg = <?php echo $lastID; ?>;
	var currentID = <?php echo $_SESSION['currentID']; ?>;
		$(".next").prop('disabled', true);
		$(".prev").prop('disabled', true);
		var id = $(".panel:first-child").attr('id');
		var idNumber = id.substring(4);
		var feedType = $(".navigation .active").attr('id');
		for (i = 1; i < 10; i++) 
		{ 
			$(".panels .panel:nth-child("+i+")").addClass("pos"+i+"").removeClass("pos"+(i-1)+"");
		}
		var pageValue = $(".next").attr("page-value");
		$.ajax({
		    type: 'POST',
		    url: 'load-update.php',
		    data: { currentID: idNumber, direction: 'up', pageValue:pageValue,feedType:feedType},
			success: function(data, status)
		    {
		        $(".panels").prepend(data);
				if(pageValue<total-8){	pageValue++;	}
				else{	pageValue = 1;	}
				$(".next").attr( "page-value", pageValue );
	            $(".prev").attr( "page-value", pageValue ); 
				if ($(".panel").length > 10) 
				{
					$(".panel:last-child").remove();
				}
				$(".next").prop('disabled', false);
				$(".prev").prop('disabled', false);
		    },
		    error: function(data, status)
		    {
		        alert("Error!");
		    }
		});
}
function nextFeedClick()
{
		var total = <?php echo $totalImages; ?>;
	var firstImg = <?php echo $firstID; ?>;
	var lastImg = <?php echo $lastID; ?>;
	var currentID = <?php echo $_SESSION['currentID']; ?>;
		$(".next").prop('disabled', true);
		$(".prev").prop('disabled', true);
		var id = $(".panel:last-child").attr('id');
		var idNumber = id.substring(4);
		var feedType = $(".navigation .active").attr('id');
		for (j = 1; j < 10; j++) 
		{ 
			$(".panels .panel:nth-child("+(j+1)+")").addClass("pos"+(j-1)+"").removeClass("pos"+(j)+"");
		}
		var pageValue = $(".next").attr("page-value");
		$.ajax({
		    type: 'POST',
		    url: 'load-update.php',
		    data: { currentID: idNumber, direction: 'down', pageValue:pageValue,feedType:feedType},
			success: function(data, status)
		    {
		        $(".panels").append(data);
				if(pageValue>1){	pageValue--;	}
				else{	pageValue = total;	}
				$(".next").attr( "page-value", pageValue );
	            $(".prev").attr( "page-value", pageValue ); 
				if ($(".panel").length > 10) 
				{
					$(".panels .panel:first-child").remove();
				}
				$(".next").prop('disabled', false);
				$(".prev").prop('disabled', false);
		    },
		    error: function(data, status)
		    {
		        alert("Error!");
		    }
		});
}
function getFeed()
{
	$.ajax({
	    type: 'POST',
	    url: 'load-update.php',
	    data: { currentID: "", direction: "", pageValue:"",feedType:"feed"},
		success: function(data, status)
	    {
	        $(".panels").html(data);
		},
		error: function(data, status)
		{
		    alert("Error!");
		}
	});	
}
function getInsta()
{
	$.ajax({
	    type: 'POST',
	    url: 'load-update.php',
	    data: { currentID: "", direction: "", pageValue:"",feedType:"insta"},
		success: function(data, status)
	    {
	        $(".panels").html(data);
		},
		error: function(data, status)
		{
		    alert("Error!");
		}
	});	
}

function searchCate(actionValue)
{
	
		$('.panels').html('<img style="margin: 62px;width: 50px;" src="/img/ajax-loader.gif" />'); 
		$.ajax({
			url: "cat_search_ajax.php?id="+actionValue,
			type:"POST",
			success: function(html){
				$('.panels').html(html); 
			}
		});
	
}
</script>
</script>
</body>
</html>