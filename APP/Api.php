<?php

//url for api call
$url= "http://api.sportradar.us/draft/nba/trial/v1/en/2019/prospects.json?api_key=nyfttfgabf7hq86m79kmxjy4";
       http://api.sportradar.us/draft/nfl/trial/v1/en/2019/prospects.json?api_key=
$url=array(
    //for getting team id
    "http://api.sportradar.us/draft/nfl/trial/v1/en/2019/prospects.json?api_key=",
    //for getting team id
    "http://api.sportradar.us/nfl/official/trial/v5/en/teams/97354895-8c77-4fd4-a860-32e62ea7382a/profile.json?api_key=",
    //for getting player stats
    "http://api.sportradar.us/nfl/official/trial/v5/en/players/41c44740-d0f6-44ab-8347-3b5d515e5ecf/profile.json?api_key=",

);
$keys = array(
  "nba"=>"nyfttfgabf7hq86m79kmxjy4",
  "lol"=> "fws7zff8ytnyzmugw6ba8vxc",
  "dota2"=>"tvkmchnyurfvyez8jzv4hma4",
  "mlb"=> "2ftdna96n3yx6q9rkekbrbbc",
  "nfl"=> "wdyztaakwe8sny3vb4prt863",
  "ufc"=> "yyutm7yrpzbexfehgaeqj289",
  "csgo"=> "rxnve45j95ac742auc5xt329"
);
$Sports=array("LOL","DOTA2","MLB","NFL","UFC","NBA","CSGO");
//call api
    // gets json frm api
$json = file_get_contents($url);
    //decodes the data
$json = json_decode($json);
    //gets data from decoded data
$result = $json->draft;

//echo json_encode($result);
echo json_encode($json);
?>
