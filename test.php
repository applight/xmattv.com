<?php
require_once('./PageGen.php'); 
$pagegen = PageGen::title('Matt Vaughan Consulting');

echo $pagegen->page("regForm");

?>