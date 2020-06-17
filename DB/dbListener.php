<?php

    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');

    require_once('dbFunctions.php');

    //Takes request from server and pushes to db
    function requestProcessor($request){
        echo "received request".PHP_EOL;
        echo $request['type'];
        var_dump($request);
        
        if(!isset($request['type'])){
            return array('message'=>"ERROR: Message type is not supported");
        }
        switch($request['type']){
                
            //Login & Authentication request    
            case "Login":
                echo "<br>login";
                $response_msg = doLogin($request['uname'],$request['pw']);
                break;
                
            case "SignUp":
                echo "<br>sign up";
                $response_msg = signUp($request['Fullname'],$request['uname'],$request['pw']);
                break;
                
            case "UserSearch":
                echo "<br>search user";
                $response_msg = searchUser($request['friend']);
                break;
        }
        
        echo $response_msg;
        return $response_msg;        
    }        

    //Creates new rabbit server
    $server = new rabbitMQServer('rabbitMQ_db.ini', 'testServer');
    
    //processes requests sent by client
    $server->process_requests('requestProcessor');
        
?>
