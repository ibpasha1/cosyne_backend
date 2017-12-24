<?php
/*
Copyright (c) Cosyne LLC 2017 - 2018 - Author Ibrahim Pasha
app general php backend functions - server side
signup - login - acccount request


'{
 "status":          "success",
 "id:               "'.$id.'",
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
*/
include 'db.php';
session_start();
//$_SESSION['id'];
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

      $JSON_OUTPUT = '{ "message":"almost welcome to coysne. check your email to verify your account "}';
      $to      = $email;
      $subject = 'Account Verification (cosyne)';
      $message_body = '
      Hello '.$first_name.',
      Thank you for signing up for cosyne!
      Please click this link to activate your account:
      http://cosyne.io/y/cosyneav.php?email='.$email.'&hash='.$hash;
      mail( $to, $subject, $message_body );
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
            $id             = $user['id'];
            $active         = $user['active'];
            $insta          = $user['insta_username'];
            $v_code         = $user['verification_code'];
            $firstname      = $user['first_name'];
            $lastname       = $user['last_name'];
            $streetaddress  = $user['street_address'];
            $city           = $user['city'];
            $state          = $user['state'];
            $zip            = $user['zip'];
            $gender         = $user['gender'];


            $JSON_OUTPUT = '{ "status":"success", "id":"'.$id.'" , "active":"'.$active.'" , "insta_username":"'.$insta.'" , "verification_code":"'.$v_code.'" ,
            "first_name":"'.$firstname.'" , "last_name":"'.$lastname.'" ,  "street_address":"'.$streetaddress.'" ,  "city":"'.$city.'" ,
            "state":"'.$state.'" , "zip":"'.$zip.'" , "gender":"'.$gender.'"}';

            echo $JSON_OUTPUT;
            //echo "success";
        } else {
            echo "that combo isn't right";
        }
    }
}

//









//update_account
if(isset($_POST['update_account']))
{
    $id                    = isset($_POST['id'])                 ? $_POST['id']                  : '';
    $insta_username        = isset($_POST['insta_username'])     ? $_POST['insta_username']      : '';
    $verification_code     = isset($_POST['verification_code'])  ? $_POST['verification_code']   : '';
    $first_name            = isset($_POST['first_name'])         ? $_POST['first_name']          : '';
    $last_name             = isset($_POST['last_name'])          ? $_POST['last_name']           : '';
    $street_address        = isset($_POST['street_address'])     ? $_POST['street_address']      : '';
    $city                  = isset($_POST['city'])               ? $_POST['city']                : '';
    $state                 = isset($_POST['state'])              ? $_POST['state']               : '';
    $zip                   = isset($_POST['zip'])                ? $_POST['zip']                 : '';
    $gender                = isset($_POST['gender'])             ? $_POST['gender']              : '';

    if ($insta_username == '' || $first_name == '' )
        {
          echo "error";
        }

        else
        {
          $mysqli->query("UPDATE cosyne_users SET id='$id',  insta_username='$insta_username', verification_code='$verification_code',
          first_name='$first_name', last_name='$last_name', street_address='$street_address', city='$city', state='$state', zip='$zip',
          gender='$gender'  WHERE id='$id'") or die($mysqli->error);

          $result = $mysqli->query("SELECT * FROM cosyne_users WHERE id='$id'");
          if ($result->num_rows == 0)
          {
              echo "mismatch";
          } else {
            $JSON_OUTPUT = '{ "insta_username":"'.$insta_username.'", "verification_code":"'.$verification_code.'"}';
            echo $JSON_OUTPUT;
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
