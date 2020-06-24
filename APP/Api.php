<?php

//url for api call
    //first one if to get team
    //second is to get player
    //third one is for getting player stats
$urls=array(
        "nfl"=>array(
            "http://api.sportradar.us/draft/nfl/trial/v1/en/2019/prospects.json?api_key=wdyztaakwe8sny3vb4prt863",
            "http://api.sportradar.us/nfl/official/trial/v5/en/teams/97354895-8c77-4fd4-a860-32e62ea7382a/profile.json?api_key=wdyztaakwe8sny3vb4prt863",
            "http://api.sportradar.us/nfl/official/trial/v5/en/players/41c44740-d0f6-44ab-8347-3b5d515e5ecf/profile.json?api_key=wdyztaakwe8sny3vb4prt863"),
        //has a updated attribute
        "nba"=>array(
            "http://api.sportradar.us/draft/nba/trial/v1/en/2019/prospects.json?api_key=nyfttfgabf7hq86m79kmxjy4",
            "http://api.sportradar.us/nba/trial/v7/en/teams/583ec825-fb46-11e1-82cb-f4ce4684ea4c/profile.json?api_key=nyfttfgabf7hq86m79kmxjy",
            "http://api.sportradar.us/nba/trial/v7/en/players/ab532a66-9314-4d57-ade7-bb54a70c65ad/profile.json?api_key=nyfttfgabf7hq86m79kmxjy4"),
        "lol"=>array(
            //first one is for getting tournament id
            //second one is for getting competitors id aka team id
            //third for team profile to get player id
            //fourth for player stats
            "http://api.sportradar.us/lol-t1/en/tournaments.json?api_key=fws7zff8ytnyzmugw6ba8vxc",
            "http://api.sportradar.us/lol-t1/en/tournaments/sr:tournament:2450/summaries.json?api_key=fws7zff8ytnyzmugw6ba8vxc",
            "http://api.sportradar.us/lol-t1/en/teams/sr:competitor:240582/profile.json?api_key=fws7zff8ytnyzmugw6ba8vxc",
            "http://api.sportradar.us/lol-t1/en/players/sr:player:949022/profile.json?api_key=fws7zff8ytnyzmugw6ba8vxc"),
        "csgo"=>array(
            "http://api.sportradar.us/csgo-t1/en/tournaments.json?api_key=rxnve45j95ac742auc5xt329",
            "http://api.sportradar.us/csgo-t1/en/tournaments/sr:tournament:2390/summaries.json?api_key=rxnve45j95ac742auc5xt329",
            "http://api.sportradar.us/csgo-t1/en/teams/sr:competitor:220602/profile.json?api_key=rxnve45j95ac742auc5xt329",
            "http://api.sportradar.us/csgo-t1/en/players/sr:player:917768/profile.json?api_key=rxnve45j95ac742auc5xt329"),
        "dota2"=>array(
            "http://api.sportradar.us/dota2-t1/en/tournaments.json?api_key=tvkmchnyurfvyez8jzv4hma4",
            "http://api.sportradar.us/dota2-t1/en/tournaments/sr:tournament:2390/summaries.json?api_key=tvkmchnyurfvyez8jzv4hma4",
            "http://api.sportradar.us/dota2-t1/en/teams/sr:competitor:220602/profile.json?api_key=tvkmchnyurfvyez8jzv4hma4",
            "http://api.sportradar.us/dota2-t1/en/players/sr:player:917768/profile.json?api_key=tvkmchnyurfvyez8jzv4hma4")
          );
$sports=array("lol","dota2","nfl","nba","csgo");
$returnval=array(
  "sports"=>array(),
  "esports"=>array()
);
foreach($sports as $sport){
    foreach($urls[$sport] as $url){
        $json = file_get_contents($url);
        $json = json_decode($json);
        $add = array();
        if ($sport=="nba" or $sport=="nfl"){
          array_push($returnval["sports"],$url);
        }
        else{
          array_push($returnval["esports"],$url);
        }
    }
}
//call api
    // gets json frm api
//$json = file_get_contents($url);
    //decodes the data
//$json = json_decode($json);
    //gets data from decoded data
//$result = $json->draft;

//echo json_encode($result);
//echo json_encode($json);
?>
