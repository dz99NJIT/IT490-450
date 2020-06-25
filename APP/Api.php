<?php
ini_set('max_execution_time', 0);
$context = stream_context_create(
  array(
      'http' => array(
        'method'  => 'GET',
        'header'  => "Content-Type: application/json\r\n",
        //'ignore_errors' => TR\UE,
        'content' => $reqBody),
  )
);
$keys = array (
    "nfl"=>"wdyztaakwe8sny3vb4prt863",
    "nba"=>"nyfttfgabf7hq86m79kmxjy4",
    "lol-t1"=>"fws7zff8ytnyzmugw6ba8vxc",
    "csgo-t1"=>"rxnve45j95ac742auc5xt329",
    "dota2-t1"=>"tvkmchnyurfvyez8jzv4hma4"
);
$urls = array(
  "nfl"=>
      "http://api.sportradar.us/draft/nfl/trial/v1/en/2019/prospects.json?api_key=wdyztaakwe8sny3vb4prt863"
      //"http://api.sportradar.us/nfl/official/trial/v5/en/teams/97354895-8c77-4fd4-a860-32e62ea7382a/profile.json?api_key=wdyztaakwe8sny3vb4prt863",
      //"http://api.sportradar.us/nfl/official/trial/v5/en/players/41c44740-d0f6-44ab-8347-3b5d515e5ecf/profile.json?api_key=wdyztaakwe8sny3vb4prt863"
  ,
  "nba"=>
      "http://api.sportradar.us/draft/nba/trial/v1/en/2019/prospects.json?api_key=nyfttfgabf7hq86m79kmxjy4"
      //"http://api.sportradar.us/nba/trial/v7/en/teams/583ec825-fb46-11e1-82cb-f4ce4684ea4c/profile.json?api_key=nyfttfgabf7hq86m79kmxj",
      //"http://api.sportradar.us/nba/trial/v7/en/players/ab532a66-9314-4d57-ade7-bb54a70c65ad/profile.json?api_key=nyfttfgabf7hq86m79kmxjy4"
    ,
  "lol-t1"=>
      "http://api.sportradar.us/lol-t1/en/tournaments.json?api_key=fws7zff8ytnyzmugw6ba8vxc"
      //"http://api.sportradar.us/lol-t1/en/tournaments/sr:tournament:2450/summaries.json?api_key=fws7zff8ytnyzmugw6ba8vxc",
      //"http://api.sportradar.us/lol-t1/en/teams/sr:competitor:240582/profile.json?api_key=fws7zff8ytnyzmugw6ba8vxc",
      //"http://api.sportradar.us/lol-t1/en/players/sr:player:949022/profile.json?api_key=fws7zff8ytnyzmugw6ba8vxc"
  ,
  "csgo-t1"=>
      "http://api.sportradar.us/csgo-t1/en/tournaments.json?api_key=rxnve45j95ac742auc5xt329"
    //  "http://api.sportradar.us/csgo-t1/en/tournaments/sr:tournament:2390/summaries.json?api_key=rxnve45j95ac742auc5xt329",
      //"http://api.sportradar.us/csgo-t1/en/teams/sr:competitor:220602/profile.json?api_key=rxnve45j95ac742auc5xt329",
      //"http://api.sportradar.us/csgo-t1/en/players/sr:player:917768/profile.json?api_key=rxnve45j95ac742auc5xt329"
    ,
  "dota2-t1"=>
      "http://api.sportradar.us/dota2-t1/en/tournaments.json?api_key=tvkmchnyurfvyez8jzv4hma4",
      //"http://api.sportradar.us/dota2-t1/en/tournaments/sr:tournament:14029/summaries.json?api_key=tvkmchnyurfvyez8jzv4hma4",
      //"http://api.sportradar.us/dota2-t1/en/teams/sr:competitor:220602/profile.json?api_key=tvkmchnyurfvyez8jzv4hma4",
      //"http://api.sportradar.us/dota2-t1/en/players/sr:player:917768/profile.json?api_key=tvkmchnyurfvyez8jzv4hma4"

);
$sports=array("lol-t1","dota2-t1","csgo-t1","nfl","nba");
$returnval=array();
//goes through each url and gets json data
function tournaments($sport){
  $returnval=array();
  $json = json_decode(file_get_contents($urls[$sport],true,$context));
  sleep(1);
  foreach($json->tournaments as $tournament){
      $returnval["tournaments"]=$tournament->id;
  }
  return $returnval;
}
if(file_exists("things.json")){

}
else{
    foreach($sports as $sport){
        if($sport!="dota2-t1"){continue;}
        $add=array("sport"=>$sport, "teamsId"=>array(),"tournaments"=>array());
        //adds team id for sports
        //and tournament if for esports
        sleep(1);
        //$json = json_decode(file_get_contents($urls[$sport],true,$context));
        sleep(1);
        //get tournament id
        if($sport=="lol-t1" or $sport=="dota2-t1" or $sport=="csgo-t1"){
            //adds tournamentId
            $add["tournaments"]=tournaments($sports);
            //add TeamId
            foreach($add["tournaments"] as $tournament){
                $url="http://api.sportradar.us/" . $sport . "/en/tournaments/" . $tournament . "/summaries.json?api_key=" . $keys[$sport];
                $json= json_decode(file_get_contents($url,true,$context));
                sleep(1);
                foreach($json->summaries as $match){
                    foreach($match->sport_event->competitors as $team){
                        if(!array_key_exists($team->id,$add["teamsId"])){
                            $add["teamsId"][$team->id]=array("name"=>$team->name,"abbreviation"=>$team->abbreviation);
                        }
                    }

                }
            }
            //add player id
            $add["teamsId"][$teamId]["players"]=array();
            foreach(array_keys($add["teamsId"]) as $teamId){
                $url="http://api.sportradar.us/" . $sport . "/en/teams/" . $teamId . "/profile.json?api_key=" . $keys[$sport];
                $json= json_decode(file_get_contents($url,true,$context));
                sleep(1);
                foreach($json->players as $player){
                  if(!array_key_exists($player->id,$add["teamsId"][$teamId]["players"])){
                      $add["teamsId"][$teamId]["players"][$player->id]=array("name"=>$player->name,"birthday"=>$player->date_of_birth,"nationality"=>$player->nationality,"gender"=>$player->gender);
                  }
                }
            }
        }
        else{
          //get's team id
          foreach($json->prospects as $item){
              if($item->team->id!=""){
                  array_push($add["teamId"],$item->team->id);
              }
          }
        }
        //adds
        $num+= 1;

        //print thing out
        echo "<h1>{$add['sport']}</h1>";
        echo count($add["teamsId"]);
        foreach($add["tournamentId"] as $item){
            echo $item . "<br>";
        }
        $sportnum+=1;
        //add $add to returnval
        array_push($returnval,$add);
    }
    //saves data as json file to make updating easier
    //$jsonfile=fopen("things.json","w");
    //fwrite($jsonfile,json_encode($returnval));
    //fclose($jsonfile);
}

echo "hello<br>";

?>
