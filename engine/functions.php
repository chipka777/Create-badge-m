<?php 
require("classes.php");
require("phpmailer/PHPMailerAutoload.php");

function sendMail($to, $sub, $msg) {

//PHPMailer Object
$mail = new PHPMailer;

//From email address and name
$mail->From = "noreply@badgem.com";
$mail->FromName = "Badgem Webmail";

//To address and name
$mail->addAddress($to);

//Address to which recipient will reply
$mail->addReplyTo("noreply@badgem.com", "Reply");


//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = $sub;
$mail->Body = $msg;

if(!$mail->send()) 
{
    return true;
} 
else 
{
    return false;
}

}

function adminFeed() {

$db = new Connection();
$conn = $db->dbConnect();
$st = $conn->prepare("SELECT * FROM images WHERE approved != 2 ORDER BY id DESC");
$st->execute();
$setupNot = "";
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

function archiveFeed() {

$db = new Connection();
$conn = $db->dbConnect();
$st = $conn->prepare("SELECT * FROM images WHERE approved = 2");
$st->execute();
while($img = $st->fetch()) {
if($img['approved']==0) {
$approved = '<div class="waiting">NEW</div>';
}
else {
$approved = '';
}
$image = "http://create.badge-m.com/upload/".$img['name'];
echo "<div class='img'><img src='".$image."' /></div>";
}

}
function catTags() 
{
$db = new Connection();
$conn = $db->dbConnect();
$st = $conn->prepare("SELECT cat_name FROM category GROUP BY cat_name");
$st->execute();
$outputstring = "";
while($tagscat = $st->fetch()) 
{
	if($tagscat['cat_name']!=="")
	$outputstring.="<option value='".$tagscat['cat_name']."'>".$tagscat['cat_name']."</option>";
}
echo $outputstring;
}

?>