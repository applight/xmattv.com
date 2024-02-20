<?php 
require_once ('./PageGen.php'); 
require_once ('./UserManagement.php'); 

$pagegen = PageGen::title('Matt Vaughan Consulting');
?>
<!DOCTYPE HTML>
<html>
<?php echo $pagegen->head(); ?>

<body class="is-preload">

<!-- Header -->
<?php echo $pagegen->header(); ?>

<!-- Nav -->
<?php echo $pagegen->nav(); ?>

<!-- Banner -->
<?php echo $pagegen->banner(); ?>

<?php 

echo $pagegen->regForm();
echo $pagegen->footer();
echo $pagegen->tailscripts();
?>
</body>
</html>