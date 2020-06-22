<?php

//url for api call
$url= "http://api.sportradar.us/draft/nba/trial/v1/en/2019/prospects.json?api_key=nyfttfgabf7hq86m79kmxjy4";

//call api
$json = file_get_contents($url);
$json = json_decode($json);
$result = $json->draft->id;
echo "hello<br>";
echo "results: ";
echo $result;
echo "<br>"
?>
