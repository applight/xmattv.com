<?php
session_start();
$_SESSION['loggedIn'] = false;
$_SESSION['phone'] = null;
header("Location: index.php");
?>