<?php 
require_once ('./PageGen.php'); 
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

	// lets try to create the database

	if ( ! isset($_POST['phone']) && ! isset($_POST['code']) ) {
		echo $pagegen->regForm();
	} elseif ( ! isset($_POST['code']) ) {
		echo $pagegen->otp();
	} else {
		echo "<p>User registered and 2fa verified!</p>";
	}
	
	echo $pagegen->footer();
	echo $pagegen->tailscripts();
?>
</body>
</html>