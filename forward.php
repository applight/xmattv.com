<?php

require_once './vendor/autoload.php';

use Twilio\TwiML\MessagingResponse;

$response = new MessagingResponse();
$message = $response->message($_REQUEST['To'] . ":" . $_REQUEST['Body'], [ 'To' => '15613133416']);

echo $response;
?>