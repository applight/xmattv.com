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

<!-- Heading -->
<div id="heading" >
<h1>Resume</h1>
</div>

<embed src="https://drive.google.com/viewerng/viewer?embedded=true&url=https://xmattv.com/resume.pdf" width="100%" height="875">
	  
<?php
echo $pagegen->footer();
echo $pagegen->tailscripts();
?>

	</body>
</html>
