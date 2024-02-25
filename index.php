<?php 
require_once('./PageGen.php'); 
$pagegen = PageGen::title('Matt Vaughan Consulting');

$pageContent = function() {
	return <<<EOF
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
	EOF;
};

echo $pagegen->contentWrap( $pageContent );
?>
