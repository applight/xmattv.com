<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php 

// DEBUG FLAG
$DEBUG = true;

// we will show the form with partial values unless the user has just successfully created an account 
// or if we encounter an error that indicates a foreign/broken/hacked request
$show_form_values = true;

// if username is set, we can assume we've received a post...
if ( isset($_POST['username']) ) {

    // check to make sure the post has the rest of the data we need
    if ( !isset($_POST['password']) || !isset($_POST['password_confirmation']) || !isset($_POST['password']) || !isset($_POST['firstname']) 
    || !isset($_POST['lastname']) || !isset($_POST['phone_number']) || !isset($_POST['pin']) ) {
        $show_form_values = false;
        echo '<p>We\'re sorry. We had trouble registering your account. Please try again later.</p>';
    }
    // make sure the values passed contain characters we are expecting - only 
    elseif ( !ctype_alnum($_POST['username']) || !ctype_alnum($_POST['password']) || !ctype_alnum($_POST['password_confirmation']) 
    || !ctype_digit($_POST['pin']) || !ctype_digit($_POST['phone_number']) || !ctype_alpha($_POST['firstname']) || !ctype($_POST['lastname']) ) {
        //TODO -- fix firstname and lastname ctypes for apostrophes and unicode names
        echo '<p>There were problems with the data you gave us! Please check the form below and try again.</p>';
    }
    // add the new user to the database and indicate success 
    else {
        if ( $DEBUG ) {
            echo '<p>DEBUG TESTING BLOCK REACHED</p>';
        }
        $show_form_values = false;

        $username               = trim(strip_tags($_POST['username']));
        $password               = trim(strip_tags($_POST['password']));
        $password_confirmation  = trim(strip_tags($_POST['passowrd_confirmation']));
        $pin                    = trim(strip_tags($_POST['pin']));
        $lastname               = trim(strip_tags($_POST['lastname']));
        $firstname              = trim(strip_tags($_POST['firstname']));
        $phone_number           = trim(strip_tags($_POST['phone_number']));

        // create a salt, hash password, database add

        echo '<p>We successfully added ' . $username . ' to our database<br/>'
        . 'click <a href="./login.php">here</a> to login!</p>';
    }

}

function ff( $field ) {
    if ( ! $_SESSION['show_reg_form_vals'] ) {
        return "";
    }
    else if ( isset($_POST[$field]) && htmlspecialchars($_POST[$field],) == $_POST[$field] )
        return trim(strip_tags($_POST[$field]));
    else
        return "";
}

echo '<form action="./register.php" method="POST">' 
    . '<label for="username">Username</label><input type="text" id="username" name="username" value="' . ff('username') . '" ></input><br/>'
    . '<label for="password">Password</label><input type="password" id="password" name="password" value="' . ff('password') . '"></input><br/>'
    . '<label for="password_confirmation">Confirm Password</label><input type="password" id="password_confirmation" name="password_confirmation"></input><br/>'
    . '<label for="firstname">First Name</label><input type="text" id="firstname" name="firstname" value="' . ff('firstname') . '"></input><br/>'
    . '<label for="lastname">Last Name</label><input type="text" id="lastname" name="lastname" value="' . ff('lastname') . '"></input><br/>'
    . '<label for="phone_number">Phone Number</label><input type="text" id="phone_number" name="phone_number" value="' . ff('phone_number') . '"></input><br/>'
    . '<label for="pin">Pin</label><input type="text" id="pin" name="pin" value="' . ff('pin') . '"></input><br/>'
    . '<input type="submit" name="submit" value="submit" id="submit" />'
    . '</form>';


?>

</body>
</html>