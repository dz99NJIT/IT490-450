<?php

//Required files
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('AppRabbitMQClient.php');
include("functions.php");
include("landingPage.php");

session_start();
$type = $_POST["type"];
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
  //Sign up Case
  case "SignUp":
    $Fullname = $_POST["Fullname"];
    $uname = $_POST["uname"];
    $pw = $_POST["pw"];
	  $confirmPw = $_POST["confirmPw"];

  	if ($confirmPw!=$pw){
          echo '<div class="alert alert-danger" role="alert">Passwords do not match, try again</div>';
  	}
    else{
      //error in signup is here
      $response = signUp($Fullname, $uname, $pw);
      echo "<script>alert('Signup successfull');</script>";

  		if ($response == true){
  			return '<div class="alert alert-success" role="alert">Successfully created your account, please login to the left!</div>';}
  	}
  	break;

  default:
    return "Default Case";
}
echo "done";
?>
