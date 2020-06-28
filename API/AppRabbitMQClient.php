<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

//Creates Rabbit client for the DB query requests
function createClientForDb($request){
        $client = new rabbitMQClient("rabbitMQ_db.ini", "testServer");
        
        if(isset($argv[1])){
            $msg = $argv[1];
        }
        else{
            $msg = "client";
        }
        
        $response = $client->send_request($request);
        return $response;
    }
?>
