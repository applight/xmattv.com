<?php

// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once './vendor/autoload.php';

use Twilio\Rest\Client;

// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = getenv("TWILIO_ACCOUNT_SID");
$token = getenv("TWILIO_AUTH_TOKEN");
$twilio= new Client($sid, $token);
?>

<!DOCTYPE HTML>
<html>
    <head>
	<title>Matt Vaughan</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="stylesheet" href="assets/css/main.css" />
    </head>
    <body class="is-preload">
	
	<!-- Header -->
	<?php require('./header.php'); ?>
	
	<!-- Nav -->
	<?php require('./nav.php'); ?>
	
	<!-- Banner -->
	<section id="banner"
		 style="background-image: url('./images/banner.jpg');">
	    <div class="inner">
		<h1>Life Philosophy</h1>
		<p>"Live a good life. <br />If there are gods and they are just, then they will not care how devout you have been, but will welcome you based on the virtues you have lived by. If there are gods, but unjust, then you should not want to worship them. If there are no gods, then you will be gone, but will have lived a noble life that will live on in the memories of your loved ones." <br /> --Marcus Aurelius
		    <p>
	    </div>
	</section>
	
<?php

$conversations = [];

$messages = $twilio->messages->read([], 20);

echo "<div><ol>";
foreach ($messages as $record) {
    echo "<li>from {$record->from} to {$record->to} : {$record->body}</li>";
	if ( !isset($conversations[$record->from]) ) $conversations[$record->from] = [];
}
echo "</ol></div>";

echo "<div><ul>";
foreach ($conversations as $from => $arr) {
	echo "<lh>{$from}</lh>";
}
echo "</ul></div>";


?>

    <?php require('./footer.php'); ?>
	
	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/browser.min.js"></script>
	<script src="assets/js/breakpoints.min.js"></script>
	<script src="assets/js/util.js"></script>
	<script src="assets/js/main.js"></script>
    
  </body>
</html>