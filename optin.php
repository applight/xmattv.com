<?php require('./PageGen.php'); 
$pagegen = PageGen::title('App Lighting');
?>
<!DOCTYPE HTML>
<html>

    <?php echo $pagegen->head('app.css'); ?>
    <body class="is-preload">
	
	<!-- Header -->
	<?php echo $pagegen->header(); ?>
	
	<!-- Nav -->
	<?php echo $pagegen->nav(); ?>
	
	<!-- Banner -->
	<section id="banner"
		 style="background-image: url('./images/banner.jpg');">
	    <div class="inner">
		<h1>Life Philosophy</h1>
		<p>"Live a good life. <br />If there are gods and they are just, then they will not care how devout you have been, but will welcome you based on the virtues you have lived by. If there are gods, but unjust, then you should not want to worship them. If there are no gods, then you will be gone, but will have lived a noble life that will live on in the memories of your loved ones." <br /> --Marcus Aurelius
		    <p>
	    </div>
	    <!-- <img src="./images/banner.jpg"></img> -->
	    <!--<video autoplay loop muted playsinline src="./images/banner.mp4"></video>-->
	</section>

    <?php 
        echo $pagegen->optIn();
        echo $pagegen->footer();
        echo $pagegen->tailscripts();
    ?>
</body>
</html>