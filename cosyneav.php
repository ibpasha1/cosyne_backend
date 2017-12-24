<?php

require 'db.php';
session_start();

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{
    $email = $mysqli->escape_string($_GET['email']);
    $hash = $mysqli->escape_string($_GET['hash']);


    $result = $mysqli->query("SELECT * FROM cosyne_users WHERE email='$email' AND hash='$hash' AND active='0'");

    if ( $result->num_rows == 0 )
    {
        $_SESSION['message'] = "Account has already been activated or the URL is invalid!";
        echo "error";
    }
    else {
        $_SESSION['message'] = "Your account has been activated!";
        $mysqli->query("UPDATE cosyne_users SET active='1' WHERE email='$email'") or die($mysqli->error);
        $_SESSION['active'] = 1;
        echo "success";
    }
}
else {
    $_SESSION['message'] = "Invalid parameters provided for account verification!";
    header("location: error.php");
    echo "error";
}
?>
