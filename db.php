<?php

//local means localhost obviously
header("Access-Control-Allow-Origin: *");
$local = true;


if ($local == true) 
{
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'cosyne_base';
} else if ($local == false) {

    $host = 'localhost';
    $user = 'ibpasha1';
    $pass = 'Newdad123!';
    $db   = 'analoog';

}

//echo $host, $user, $db;

$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);


// other connection:

//$local2 = true;


if ($local == true) 
{
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "cosyne_base";

} else if ($local == false) {

    $servername = 'localhost';
    $username   = 'ibpasha1';
    $password   = 'Newdad123!';
    $dbname     = 'analoog';

}

//echo $servername, $username, $dbname;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



// other connection:

$local = true;

if ($local == true) 
{
    $link = mysqli_connect("localhost", "root", "", "cosyne_base");
    
} else if ($local == false) {
    $link = mysqli_connect("localhost", "ibpasha1", "Newdad123!", "analoog");
    
}



if($link === false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
?>

