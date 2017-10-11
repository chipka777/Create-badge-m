<?php 
session_start();
error_reporting(1);
include("engine/functions.php");

if ($_POST['btnSave']) {
	$name = $_POST['imgName'];
	$userID = $_SESSION['user'];
	$datetime = date('YYYY-mm-dd h:i:s');
	$tags = $_POST['tags'];
	$title = $_POST['title'];
	
	// PLUG INTO DATABASE
	$db = new Connection();
	$conn = $db->dbConnect();
	$st = $conn->prepare("INSERT INTO images VALUES ('','$name','$userID','$date','$tags','$title','0')");

	$submitImage = $st->execute();
	
	if ($submitImage==true) {
		
		//header("Location: index.php?m=uploadsuccess");
	}
	else {
		
		header("Location: index.php?m=uploadfail");
	}
}


?>
<!DOCTYPE html>
<html>
<head>
<title>Badgem Members Home</title>

<link rel="stylesheet" href="printstyle.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<script src="//code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="html2canvas/dist/html2canvas.js"></script>
<script type="text/javascript" src="jsPDF-master/dist/jspdf.debug.js"></script>

</head>
<body>
<?php if ($requestType=='post') { ?>


<?php } ?>

<div class="frame-area">
<div id="frame" class="frame">
	<div class="frame-img">
		<img src="upload/<?php echo $_POST['imgName']; ?>" />
	</div>
</div>
</div>

<div class='bottom-nav'>
	<div id="portrait" class="portrait orientation active">Portrait</div>
	<div id="land" class="land orientation">Landscape</div>
	<div class="rotate-slider">Rotation 
	<div class="rotation"></div></div>
	<input type="button" id="btnSave" value="MAKE PDF"/>
</div>
<div class="directions">
	<div class="close">x</div>
	<h1>Badge Print Instructions</h1>
	<h2>1. Open your PDF on your computer</h2>
	<h2>2. Load your Badgem badge into the printer, setting up the tray for 4 x 6 paper</h2>
	<h2>3. File > Print</h2>
	<h2>4. Turn OFF "Shrink to Fit"</h2>
	<h2>5. Choose 4 x 6 Paper Size</h2>
	<h2>6. Print!</h2>
</div>
<script>

var orient = 1;
var imgName = '<?php echo $_POST['imgName']; ?>';

$(".portrait").click(function () {
	var orient = 1;
	$('.portrait').addClass('active');
	$('.land').removeClass('active');
	$('.frame-area').removeClass('landscape');
	$('.frame').removeClass('landscape');
});

$(".land").click(function () {
	var orient = 2;
	$('.land').addClass('active');
	$('.portrait').removeClass('active');
	$('.frame-area').addClass('landscape');
	$('.frame').addClass('landscape');
});


$(function() { 
    $("#btnSave").click(function() { 
    
        html2canvas($("#frame"), {
                    onrendered: function(canvas) {     
                    	if ($('#land').hasClass('active')) {
                    		// create intermediate canvas
                    		    var rotCanvas = document.createElement("canvas");
                    		
                    		    // swap width and height
                    		    rotCanvas.width = canvas.height;
                    		    rotCanvas.height = canvas.width;
                    		
                    		    // get context
                    		    var rctx = rotCanvas.getContext("2d");
                    		
                    		    // translate to center (rotation pivot)
                    		    rctx.translate(rotCanvas.width * 0.5, rotCanvas.height * 0.5);
                    		
                    		    // rotate -90° (CCW)
                    		    rctx.rotate(-Math.PI * 0.5);
                    		
                    		    // draw image offset so center of image is on top of pivot
                    		    rctx.drawImage(canvas, -canvas.width * 0.5, -canvas.height * 0.5);
                    		
                    		    // extract image from rotate canvas
                    		    var imgData = rotCanvas.toDataURL('image/png');
                    		    var doc = new jsPDF('p', 'mm', [152, 101]);
                    	}
                    	else {
                    	var imgData = canvas.toDataURL(
                    	    'image/png');              
                    	var doc = new jsPDF('p', 'mm', [101, 152]);
                    	}  
                        
                        doc.addImage(imgData, 'PNG', 0, 0);
                       	doc.save('badgem.pdf');
                        
                        $(".directions").addClass('shown');
                    }
                });
    });
}); 




$( function() {
  $( ".stroke" ).slider();
} );

$( function() {
  $( ".frame-img" ).resizable();
} );

$( function() {
  $( ".frame-img" ).draggable();
} );

$( function() {
  $( ".rotation" ).slider();
} );

$(".stroke").on("slidestop", function(event, ui) {
	var stroke = ui.value;
	$(".frame-img img").css({
	'-webkit-filter' : 'drop-shadow(1px 1px '+stroke+'px black) drop-shadow(-1px -1px '+stroke+'px black)'
	});
});


$(".rotation").on("slidestop", function(event, ui) {
	var v = ui.value;
	var v = v * 3.6;
	$(".frame-img img").css({
	'transform' : 'rotate('+v+'deg)',
	'-webkit-transform' : 'rotate('+v+'deg)',
	'-ms-transform' : 'rotate('+v+'deg)'
	});
});

</script>
<?php include("footer.php");?>