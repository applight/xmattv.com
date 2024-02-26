<?php require_once('./PageGen.php'); 
$pagegen = PageGen::title('Matt Vaughan Consulting');
echo $pagegen->contentWrap(<<<EOF
<!-- Heading -->
<div id="heading" >
<h1>Resume</h1>
</div>
<embed src="https://drive.google.com/viewerng/viewer?embedded=true&url=https://xmattv.com/resume.pdf" width="100%" height="875">
EOF);

?>