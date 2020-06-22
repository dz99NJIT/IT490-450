<?php

//url for api call
$url= "http://api.sportradar.us/draft/nba/trial/v1/en/2019/prospects.json?api_key=nyfttfgabf7hq86m79kmxjy4";

//call api
    // gets json frm api
$json = file_get_contents($url);
    //decodes the data
$json = json_decode($json);
    //gets data from decoded data
$result = $json->draft->id;
echo "hello<br>";
echo "results: ";
echo $result;
echo "<br>"
?>
