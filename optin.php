<?php require_once('./PageGen.php'); 
$pagegen = PageGen::title('Matt Vaughan Consulting');

echo $pagegen->contentWrap( function($pg) {
	return "<p>Please register first at <a href='register.php'>registration</a></p>!<!-- I don\'t like writing it this way:Coolify() -->"
	. $pg->optin();
	}, [ "pg" => $pagegen ] 
);
?>