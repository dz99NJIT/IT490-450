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
	 
 	$numRows = mysqli_num_rows($response);

        if ($numRows>0)
	{
		/*
		$passMatch = password_verify($pw, $response);
		if($passMatch == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
		 */
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
	$key = md5(time().$uname);
        $mydb = dbConnect();
	 
	$query = "INSERT INTO `users`(`fullname`, `email`, `username`, `pw`, `verificationkey`) VALUES ('$Fullname','$email','$uname','$pw', '$key');";
        //$query = "insert into users values ('$Fullname', '$uname', '$pw');";
        $response = mysqli_query($mydb, $query);
	    
    	return true;
       
    }

?>
