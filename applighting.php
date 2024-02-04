<?php 
require_once('./PageGen.php'); 
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
	</section>
	
	<!-- Highlights -->
	<section class="wrapper">
	    <div class="inner">
		<header class="special">
		    <h2>App Lighting</h2>
		    <p>Experiments in Communication</p>
		</header>
			<div class="highlights">
				<section>
				<div class="content">
					<header>
					<a href="https://github.com/applight" class="icon fa-code"><span class="label">Icon</span></a>
					<h3>Github</h3>
					</header>
				</div>
				</section>
            </div>
        </div>
    </section>  

    <?php 
	$fb = new FormBuilder("POST", "applighting.php");
		$fb->text("First Name", "first", "first", "[a-zA-Z ]+", true, "first name");
		$fb->text("Last Name", "last", "last","[a-zA-Z ]+", true, "last name" );
		$fb->email("email", true);
		$fb->submit("submit");
		echo $fb->toString();
        echo $pagegen->footer();
        echo $pagegen->tailscripts();
    ?>
</body>
</html>