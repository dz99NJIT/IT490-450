<?php

//Required files
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('AppRabbitMQClient.php');
include("functions.php");
include("landingPage.php");

//enables error messages
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
echo "<script>console.log('pass1');</script>";

$type = $_POST["type"];
echo "<script>console.log('pass2 ');</script>";

switch ($type){

  //Login Case
  case "Login":

    $uname = $_POST["uname"];
    $pw = $_POST["pw"];

    $response = login($uname, $pw);

    if (!$response){
     	echo $response;
		echo '<div class="alert alert-danger" role="alert">Incorrect login, please try again!</div>';
		}
		else{
			echo $response;
		}
    break;
 echo "<script>console.log('pass3 ');</script>";

  //Sign up Case
  case "SignUp":

    $Fullname = $_POST["Fullname"];
    $uname = $_POST["uname"];
    $pw = $_POST["pw"];
	$confirmPw = $_POST["confirmPw"];

	if ($confirmPw!=$pw){
        return '<div class="alert alert-danger" role="alert">Passwords do not match, try again</div>';
	}
    else{
    	$response = signUp($Fullname, $uname, $pw);
		if ($response == true){
			return '<div class="alert alert-success" role="alert">Successfully created your account, please login to the left!</div>';}
	}
	break;

  default:
    return "Default Case";
}
?>
