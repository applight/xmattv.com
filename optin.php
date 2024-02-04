<?php require_once('./PageGen.php'); 
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
	//echo $pagegen->registrationForm();
	echo $pagegen->optIn();
	echo $pagegen->footer();
	echo $pagegen->tailscripts();
?>
</body>
</html>