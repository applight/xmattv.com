<?php
require_once('./UserManagement.php');

$pattern = "/^\+[0-9]+$/";
$phone = $_POST['To'];

if ( $phone->preg_match($pattern) ) {
    UserManagement::incNotifications( $phone );
    echo "Success!";
} else {
    echo "Failure!";
}

?>