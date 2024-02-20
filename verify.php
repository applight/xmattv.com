<?php 
require_once ('./PageGen.php'); 
require_once ('./UserManagement.php'); 

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
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
};

if ( isset($_POST['phone']) && isset($_POST['first']) && isset($_POST['last']) && isset($_POST['email']) ) {
	
	$first = $test_input($_POST["first"]);
	if (!preg_match("/^[a-zA-Z]+$/",$first)) {
		return "<p>Only letters allowed in a first name</p>";
	}

	$last = $test_input($_POST["last"]);
	if (!preg_match("/^[a-zA-Z]+$/",$last)) {
		return "<p>Only letters allowed in a last name</p>";
	}

	$email = $test_input($_POST["email"]);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return "<p>Invalid email format</p>";
	}

	$phone = $test_input($_POST["phone"]);
	if (!preg_match("/^(\+1)([0-9]{10})$/",$phone)) {
		return "<p>Phone must be in the format +18005551212</p>";
	}

	$id = UserManagement::registerUser($first,$last,$email,$phone);
	if ( ! $id  ) {
		return "<p>Failed to register user</p>";
	}

	$verification = UserManagement::newOtp($phone);
	if ( ! $verification ) {
		return "<p>Couldn't generate one-time-password</p>";
	}
	
	echo $pagegen->otp($phone, "checkotp.php");

} else {

}

echo $pagegen->footer();
echo $pagegen->tailscripts();
?>
</body>
</html>