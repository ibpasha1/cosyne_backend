<?php
/*
Copyright (c) Cosyne LLC 2017 - 2018 - Author Ibrahim Pasha
app general php backend functions - server side
signup - login - acccount request
*/
include 'db.php';
header("Access-Control-Allow-Origin: *");

if(isset($_POST['signup']))
{
    $id        = isset($_POST['id'])  ? $_POST['id']  : '';
    $email     = isset($_POST['email'])  ? $_POST['email']  : '';
    $password  = isset($_POST['password'])  ? $_POST['password']  : '';
    $hash      = $mysqli->escape_string( md5( rand(0,1000) ) );
    $hash_password = password_hash($password, PASSWORD_BCRYPT);


$result = $mysqli->query("SELECT * FROM cosyne_users WHERE email='$email'") or die ($mysqli->error);
if ( $result->num_rows > 0 )
{
    echo "exist";
}
else {

    $new_id = rand();
    $date=date("d-m-y h:i:s");
    $sql = "INSERT INTO cosyne_users (id, email, password, hash) "
            . "VALUES ('$new_id','$email','$hash_password', '$hash')";
    if ( $mysqli->query($sql) )
    {
        echo "success";
    }

    else {
        echo "failed";
    }
  }
}


if(isset($_POST['login']))
{
    $email     = isset($_POST['email'])     ? $_POST['email']     : '';
    $result = $mysqli->query("SELECT * FROM cosyne_users WHERE email='$email'");

    if ($result->num_rows == 0)
    {
        echo "mismatch";
    }

    else {
        $user = $result->fetch_assoc();
        if (password_verify($_POST['password'], $user['password']))
        {
            $login_key = uniqid();
            $sql = "UPDATE cosyne_users SET login_key='$login_key' WHERE email='$email'";

            $JSON_OUTPUT = '{ "status":"'.$email.'", "email":"'.$email.'"}';
            echo $JSON_OUTPUT;
            //echo $user_token;
        } else {
            echo "that combo isn't right";
        }
    }
}

if(isset($_POST['account_request']))
{

   $email     = isset($_POST['email'])     ? $_POST['email']     : '';
   $result = $mysqli->query("SELECT * FROM cosyne_users WHERE email='$email'");
   if ($result->num_rows == 0)
   {
       echo "err";
   } else {
     $JSON_OUTPUT = '{

       "insta_username:   "'.$insta_username.'",
       "verification_code:"'.$verification_code.'",
       "first_name:       "'.$first_name.'",
       "last_name:        "'.$insta_username.'",
       "street_address:   "'.$street_address.'",
       "city:             "'.$city.'",
       "state:            "'.$state.'",
       "zip:              "'.$zip.'",
       "gender:           "'.$gender.'"

      }';

      echo $JSON_OUTPUT;
   }

}




?>
