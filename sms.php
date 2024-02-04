<?php
require_once('./PageGen.php'); 
$pagegen = PageGen::title('Matt Vaughan Consulting');

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
<?php echo $pagegen->head(); ?>

<body class="is-preload">

<?php 
echo $pagegen->header(); 
echo $pagegen->nav(); 
echo $pagegen->banner(); 

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


echo $pagegen->footer();
echo $pagegen->tailscripts();
?>
    
  </body>
</html>