<?php 
require_once ('./PageGen.php'); 
require_once ('./UserManagement.php'); 

session_start();

$pagegen = PageGen::title('Matt Vaughan Consulting');
?>
<!DOCTYPE HTML>
<html>
<?php echo $pagegen->head(); ?>

<body class="is-preload">

<!-- Header -->
<?php echo $pagegen->header(); ?>

<!-- Nav -->
<?php echo $pagegen->nav(); ?>

<!-- Banner -->
<?php echo $pagegen->banner(); ?>

<?php 

$test_input = function($data) {
	return trim(stripslashes(htmlspecialchars($data)));
};

if ( ! isset($_POST['phone']) ) {
    echo $pagegen->login();
} elseif ( isset($_POST['phone']) && !isset($_POST['code']) ) {
    
	$phone = $test_input($_POST["phone"]);
	if ( preg_match("/^(\+1)([0-9]{10})$/",$phone) ) {
		UserManagement::newOtp($phone);
		echo $pagegen->otp($phone, './login.php');
	} else {
		echo "<p>Phone number malformed!</p>";
	}
} else {
    
	$phone = $test_input($_POST["phone"]);
	$code = $test_input($_POST["code"]);
    
    if (preg_match("/^(\+1)([0-9]{10})$/",$phone) && preg_match("/^([0-9]{7})$/",$code)) {
	
		if ( UserManagement::verifyOtp($phone, $code) ) {
			$_SESSION['loggedIn'] = true;
			$_SESSION['phone'] = $phone;
			echo $pagegen->redirect('./index.php');
			echo $pagegen->clickAdvance("./index.php", "Goto home screen!");
		} else {
			echo "<p>Maybe redirect back... didn't verify</p>";
		}
	} else {
		echo "<p>Phone number and/or code were not well formed</p>";
	}
}

    echo $pagegen->footer();
echo $pagegen->tailscripts();
?>
</body>
</html>