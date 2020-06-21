<?php 

    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('AppRabbitMQClient.php');
    require_once('dbConnect.php');
    
    //Login function
    function doLogin($uname, $pw){
        
        $mydb = dbConnect();
        
        $query = "select pw from users where username = '$uname';";
        $response = $mydb->query($query);
	 
        $numRows = password_verify($pw,$response);

        if ($numRows==1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //Sign up function
    function signUp($Fullname,$email, $uname, $pw){
        $pw = password_hash($pw, PASSWORD_DEFAULT);
        $mydb = dbConnect();
	 
	$query = "INSERT INTO `users`(`fullname`, `email`, `username`, `pw`) VALUES ('$Fullname','$email','$uname','$pw');";
        //$query = "insert into users values ('$Fullname', '$uname', '$pw');";
        $response = mysqli_query($mydb, $query);
	    
    	return true;
       
    }

?>
