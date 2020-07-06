<?php

    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');

    require_once('dbFunctions.php');

    function logger($log_msg) {
    $log_filename = '/var/log/rabbit_log';
    if (!file_exists($log_filename))
    {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_msg = print_r($log_msg, true);
    $log_file_data = $log_filename.'/log_' . 'rabbit' . '.log';
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
    }


    //Takes request from server and pushes to db
    function requestProcessor($request){
        echo "received request".PHP_EOL;
        echo $request['type'];
        var_dump($request);
	
	//logger($request);

        if(!isset($request['type'])){
            return array('message'=>"ERROR: Message type is not supported");
        }
        
        $type = $request['type'];
	
	//logger($type);

	switch($type){
		
            //Login & Authentication request    
            case "Login":
                echo "<br>login";
                $response_msg = doLogin($request['uname'],$request['pw']);
                break;
                
            case "SignUp":
                echo "<br>sign up";
                $response_msg = signUp($request['Fullname'],$request['email'],$request['uname'],$request['pw']);
                break;
                
            case "Search":
                echo "<br>search user";
                $response_msg = search($request['searchText']);
                break;
        }
        
	echo $response_msg;

	//logger($response_msg);
	
	return $response_msg;        
    }        

    //Creates new rabbit server
    $server = new rabbitMQServer('rabbitMQ_db.ini', 'testServer');

    //logger($server);

    //processes requests sent by client
    $server->process_requests('requestProcessor');
        
?>
