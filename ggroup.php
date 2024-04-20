<?php

function noEOF( $str ) {
    return str_replace('^', '', str_replace('\^', '', $str));
}

$ip   = noEOF(trim($_SERVER['SERVER_ADDR']));
$name = noEOF(trim($_SERVER['SERVER_NAME']));

// simple checks
if ( $_SERVER['REQUEST_METHOD'] != 'GET' ) exit(-1);
if ( !preg_match( "/(([1-9]{1})([0-9]{0,2})\.){3}([1-9]{1})([0-9]{0,2})/" , $ip) ) exit(-2);

$url = noEOF(urldecode(trim($_GET['url'])));
$data = <<<EOF
{$url}
{$name} at: {$ip}
EOF;

file_put_contents('GGROUP_INUSE', $data, FILE_APPEND);

?>
