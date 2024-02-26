<?php
require_once('./PageGen.php'); 
$pagegen = PageGen::title('Matt Vaughan Consulting');

echo $pagegen->contentWrap(fn($a) => "foo" . $a, [ "bar" ] );
?>