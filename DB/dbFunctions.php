<?php 

    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('AppRabbitMQClient.php');
    require_once('dbConnect.php');
    
    //Login function
    function doLogin($uname, $pw){
        
        $mydb = dbConnect();
        
        $query = "select * from users where username = '$uname' && pw = '$pw';";
        $response = $mydb->query($query);
    
        $numRows = mysqli_num_rows($response);

        if ($numRows>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //Sign up function
    function signUp($Fullname, $uname, $pw){
        
        $mydb = dbConnect();
        
        $query = "insert into users values ('$Fullname', '$uname', '$pw');";
        $response = $mydb->query($query);
	    
    	return true;
       
    }

?>