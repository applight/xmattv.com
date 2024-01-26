<?php require('./PageGen.php'); 
$pagegen = PageGen::title('Matt Vaughan');
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

<!-- Highlights -->
<section class="wrapper">
	<div class="inner">
	<header class="special">
		<h2>Matt Vaughan</h2>
		<p>Software Engineer, Musician, Polyglot</p>
	</header>
		<div class="highlights">
			<section>
			<div class="content">
				<header>
				<a href="resume.php" class="icon fa-files-o"><span class="label">Icon</span></a>
				<h3>Resume</h3>
				</header>
				<p>My professional qualifications</p>
			</div>
			</section>

			<section>
			<div class="content">
				<header>
				<a href="https://github.com/applight" class="icon fa-code"><span class="label">Icon</span></a>
				<h3>Github</h3>
				</header>
				<p>A closer look at my code</p>
			</div>
			</section>
			
			<section>
			<div class="content">
				<header>
				<a href="/blog/index.php" class="icon fa-phone"><span class="label">Icon</span></a>
				<h3>Blog</h3>
				</header>
				<p>My autopublishing blog - Also check the code on <a href="https://github.com/applight/blog">github</a></p>
			</div>
			</section>

			<section>
			<div class="content">
				<header>
				<a href="https://www.youtube.com/playlist?list=PLvOG7I7MwOhHmIfWjeZgCk77PSSdMog3d" class="icon fa-music"><span class="label">Icon</span></a>
				<h3>Music</h3>
				</header>
				<p>Videos of me playing guitar and singing with friends and family who are also musicians</p>
			</div>
			</section>
			
		</div>
	</div>
</section>

<!-- CTA -->
<!--
		<section id="cta" class="wrapper">
		<div class="inner">
		<h2>Curabitur ullamcorper ultricies</h2>
		<p>Nunc lacinia ante nunc ac lobortis. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus ornare mi ut ante amet placerat aliquet. Volutpat eu sed ante lacinia sapien lorem accumsan varius montes viverra nibh in adipiscing. Lorem ipsum dolor vestibulum ante ipsum primis in faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing sed feugiat eu faucibus. Integer ac sed amet praesent. Nunc lacinia ante nunc ac gravida.</p>
		</div>
		</section>
-->
<!-- Testimonials -->
<!--
		<section class="wrapper">
		<div class="inner">
		<header class="special">
		<h2>Pallabras</h2>
		<p>Les mots des gens grandes</p>
			</header>
		<div class="testimonials">
		<section>
		<div class="content">
		<blockquote><p>“Well-being is attained little by little, and nevertheless is no little thing itself.”</p></blockquote>
		<div class="author">
			<div class="image"> <img src="images/pic01.jpg" alt="" /></div>
			<p class="credit">- <strong>Zeno of Citiumss</strong> <span>Philosopher</span></p>
		</div>
		</div>
		</section>
		<section>
		<div class="content">
			<blockquote>
		<p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
		</blockquote>
		<div class="author">
		<div class="image">
		<img src="images/pic03.jpg" alt="" />
		</div>
		<p class="credit">- <strong>John Doe</strong> <span>CEO - ABC Inc.</span></p>
		</div>
		</div>
		</section>
		<section>
		<div class="content">
		<blockquote>
		<p>Nunc lacinia ante nunc ac lobortis ipsum. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus.</p>
		</blockquote>
		<div class="author">
		<div class="image">
		<img src="images/pic02.jpg" alt="" />
		</div>
		<p class="credit">- <strong>Janet Smith</strong> <span>CEO - ABC Inc.</span></p>
		</div>
		</div>
		</section>
		</div>
		</div>
		</section> -->

<!-- Footer -->
<?php 
	echo $pagegen->footer();
	echo $pagegen->tailscripts();
?>
</body>
</html>
