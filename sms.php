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

$msgs = [];

$messages = $twilio->messages->read([], 50);

echo "<div><ol>";
foreach ($messages as $record) {
  echo "<li>from {$record->from} to {$record->to} : {$record->body}</li>";

  $high = max($record->from, $record->to);
  $lo   = min($record->from, $record->to);

  if ( !isset($msgs[$high."->".$lo]) )
    $msgs[$high."->".$lo] = [];
  
  $msgs[$high."->".$lo][] = $record;
}
echo "</ol></div>";

echo "<div class=\"messages\"><ul class=\"messages\">";
foreach ($msgs as $highlo => $ms) {
	echo "<lh class=\"msgHeader\">{$highlo}</lh>";
  foreach ($ms as $m) {
    if ( max($m->from,$m->to) == $m->from ) {
      echo "<li class=\"msgLeft\" >{$m->from} : {$m->body}</li>";
    } else {
      echo "<li class=\"msgRight\" >{$m->from} : {$m->body}</li>";
    }
  }
}
echo "</ul></div>";


echo $pagegen->footer();
echo $pagegen->tailscripts();
?>
    
  </body>
</html>