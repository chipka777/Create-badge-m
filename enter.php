<?php
session_start();

require("engine/functions.php");
if ($_SESSION['user']) {
	$_SESSION['active'] = 1;
}

include("header.php");
if ($_GET) {
	$m = $_GET['m'];
	
	if ($m=='regsuccess') {
		$msg = 'Thank you for registering, check your email!';
	}
	else if ($m=='regerror') {
		$msg = 'There was an error, please try again!';
	}
}
?>



<?php 
if ($_SESSION['active']==1) { include('home.php'); }
else { ?>
<div class="background"></div>
<div class="login-form">
	<h2>Sign In</h2>
	<form method="post" action="login.php">
		<input type="text" name="username" value="" placeholder="Username" required/>
		<input type="password" name="password" value="" placeholder="Password" required/>
		<input type="submit" name="login" value="Log In" />
	</form>
	<?php if ($m) { echo $msg; } ?>
	<span class="reg-btn">Not a Member? Register, its easy!</span>
	<form method="post" action="register.php" id="reg-form">
		<input type="text" name="email" value="" placeholder="Email" required/>
		<input type="text" name="username" value="" placeholder="Username"/>
		<input type="text" name="password" value="" placeholder="Desired Password" required/>
		<input type="submit" name="register" value="Register" />
	</form>
</div>



<div class="photobanner">
    	<img class="first" src="img/badgem1.jpg" alt="" />
    	<img src="img/badgem2.jpg" alt="" />
    	<img src="img/badgem3.jpg" alt="" />
    </div>



<script type="text/javascript">
	$(document).ready(function () {
		$(".reg-btn").click(function(){
			$("#reg-form").toggleClass('active');
		});
	});
</script>
<?php } ?>
</body>
</html>