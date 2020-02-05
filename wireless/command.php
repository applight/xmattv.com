<?php
require_once '../../vendor/autoload.php'; // Loads the library

use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$sid = getenv('TWILIO_ACCOUNT_SID');
$token = getenv('TWILIO_AUTH_TOKEN');

//$client = new Client($sid, $token);

echo "{";

foreach($_POST as $key=>$value){
    echo $key.' : '.$value.",\n";
}

echo "};";

?>