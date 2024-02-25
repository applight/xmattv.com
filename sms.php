<?php
require_once './vendor/autoload.php';
require_once('./PageGen.php'); 
$pagegen = PageGen::title('Matt Vaughan Consulting');

use Twilio\Rest\Client;

// Find your Account SID and Auth Token at twilio.com/console
// and set the environment variables. See http://twil.io/secure
$sid = getenv("TWILIO_ACCOUNT_SID");
$token = getenv("TWILIO_AUTH_TOKEN");
$twilio = new Client($sid, $token);

$msgs = [];
$messages = $twilio->messages->read([], 50);

$middle .= "<div><ol>";
foreach ($messages as $record) {
  $middle .= "<li>from {$record->from} to {$record->to} : {$record->body}</li>";

  $high = max($record->from, $record->to);
  $lo   = min($record->from, $record->to);

  if ( !isset($msgs[$high."->".$lo]) )
    $msgs[$high."->".$lo] = [];
  
  $msgs[$high."->".$lo][] = $record;
}
$middle .= "</ol></div>";

$middle .= "<div class=\"messages\"><ul class=\"messages\">";
foreach ($msgs as $highlo => $ms) {
  $middle .= "<lh class=\"msgHeader\">{$highlo}</lh>";
  foreach ($ms as $m) {
    if ( max($m->from,$m->to) == $m->from ) {
      $middle .= "<li class=\"msgLeft\" >{$m->from} : {$m->body}</li>";
    } else {
      $middle .= "<li class=\"msgRight\" >{$m->from} : {$m->body}</li>";
    }
  }
}
$middle .= "</ul></div>";

echo $pagegen->contentWrap( $middle );

?>
