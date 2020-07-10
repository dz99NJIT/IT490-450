<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

require_once('APIfunctions.php');

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
        case "populate":
            echo "<br>Populate DB";
            //populate returns string version of json file to be sent to db
            $response_msg = populate();
            break;

        case "Search_Team":
            echo "<br>Search for Team";
            //Search_Player finds player and if they exist, update their data if it's old enough
            //takes player name as parameter
            Search_Team();
            //gets string version of json file to return to db
            $response_msq = file_get_contents("data.json")
            break;
    }
    echo $response_msg;

    	//logger($response_msg);

	return $response_msg;
}

//Creates new rabbit server
$server = new rabbitMQServer('rabbitMQ_API.ini', 'testApi');

//logger($server);

//processes requests sent by client
$server->process_requests('requestProcessor');
?>
