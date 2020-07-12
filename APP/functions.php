<?php

//Required files
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('AppRabbitMQClient.php');

//Start session
//session_start();

	//Check if user is logged in, redirect to login page if not
	function loggedCheck(){
		if (!$_SESSION["logged"]){
			header("Location: index.html");
		}
	}

	//Login function
    function login($uname, $pw){

        $request = array();

        $request['type'] = "Login";
        $request['uname'] = $uname;
        $request['pw'] = $pw;

        $returnedValue = createClientForDb($request);

        if($returnedValue == 1){
            $_SESSION["uname"] = $uname;
            $_SESSION["logged"] = true;
			header("Location: landingPage.php");
			return true;
        }else{
			header("Location: index.html");
            session_destroy();
			return false;
        }
        return $returnedValue;
    }
    //Sign up function
    function SignUp($Fullname,$email, $uname, $pw){

        $request = array();

        $request['type'] = "SignUp";
				$request['Fullname'] = $Fullname;
				$request['email'] = $email;
        $request['uname'] = $uname;
        $request['pw'] = $pw;
        $returnedValue = createClientForDb($request);

        return $returnedValue;
    }

    //Search team function
    function search($searchText){

        $request = array();

        $request['type'] = "Search";
        $request['searchText'] = $searchText;

        $returnedValue = createClientForDb($request);

        return $returnedValue;
    }
		//send message to DB
		function sendMessage($username,$message){
				$request = array();
				$request['type']="Message";
				$request['message']=$message;
				$request['uname']=$username;
				return createClientForDb($request);
		}
		//update twitter posts
		function update(){
			$request=array();
			$request['type']="Update";
			return createClientForDb($request);
		}
		function FavoriteTeam($username,$teamId,$action){
				$request=array(
					'type'=>"AddFavorite",
					'username'=>$username,
					'teamId'=>$teamId,
					'action'=>$action
				);
				return createClientForDb($request);
		}
		function populate(){
			$request=array('type'=>"Populate");
			return createClientForDb($request);
		}
?>
