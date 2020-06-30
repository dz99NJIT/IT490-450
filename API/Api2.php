<?php
ini_set('max_execution_time', 0);

$context = stream_context_create(
  array(
      'http' => array(
        'method'  => 'GET',
        'header'  => "Content-Type: application/json\r\n",
        'ignore_errors' => TRUE,
        'content' => $reqBody),
  )
);
$keys = array (
    "nfl"=>array("wdyztaakwe8sny3vb4prt863","hg5ydu2npummxfdmy6h8bdrm","8s8z5ma2wrq9xnbsbvqjasap"),
    "nba"=>array("nyfttfgabf7hq86m79kmxjy4","df5afmyf2bhbne9xcqwmznps","ssx369sfjmkaw88hx923938z"),
    "lol-t1"=>array("h5cp8u2nzqghgj7hzvwr9k8q","fws7zff8ytnyzmugw6ba8vxc","xar7avr7x3hpvnn3qyfyu8qe"),
    "csgo-t1"=>array("rk7326buc7aqc72qtsudr3pv","rxnve45j95ac742auc5xt329","255tgjsbkwjmhgj8446kvzvj"),
    "dota2-t1"=>array("6h36hmhscj2z34x4bdj6w2a3","tvkmchnyurfvyez8jzv4hma4","ery3xdx8q5kntawq58g9e5zz")
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
  "lol-t1"=>"http://api.sportradar.us/lol-t1/en/tournaments.json?api_key=h5cp8u2nzqghgj7hzvwr9k8q"
      //"http://api.sportradar.us/lol-t1/en/tournaments.json?api_key=fws7zff8ytnyzmugw6ba8vxc"
      //"http://api.sportradar.us/lol-t1/en/tournaments/sr:tournament:2450/summaries.json?api_key=fws7zff8ytnyzmugw6ba8vxc",
      //"http://api.sportradar.us/lol-t1/en/teams/sr:competitor:240582/profile.json?api_key=fws7zff8ytnyzmugw6ba8vxc",
      //"http://api.sportradar.us/lol-t1/en/players/sr:player:949022/profile.json?api_key=fws7zff8ytnyzmugw6ba8vxc"
  ,
  "csgo-t1"=>"http://api.sportradar.us/csgo-t1/en/tournaments.json?api_key=rk7326buc7aqc72qtsudr3pv"
      //"http://api.sportradar.us/csgo-t1/en/tournaments.json?api_key=rxnve45j95ac742auc5xt329"
    //  "http://api.sportradar.us/csgo-t1/en/tournaments/sr:tournament:2390/summaries.json?api_key=rxnve45j95ac742auc5xt329",
      //"http://api.sportradar.us/csgo-t1/en/teams/sr:competitor:220602/profile.json?api_key=rxnve45j95ac742auc5xt329",
      //"http://api.sportradar.us/csgo-t1/en/players/sr:player:917768/profile.json?api_key=rxnve45j95ac742auc5xt329"
    ,
  "dota2-t1"=>"http://api.sportradar.us/dota2-t1/en/tournaments.json?api_key=6h36hmhscj2z34x4bdj6w2a3"
      //"http://api.sportradar.us/dota2-t1/en/tournaments.json?api_key=tvkmchnyurfvyez8jzv4hma4"
      //"http://api.sportradar.us/dota2-t1/en/tournaments/sr:tournament:14029/summaries.json?api_key=tvkmchnyurfvyez8jzv4hma4",
      //"http://api.sportradar.us/dota2-t1/en/teams/sr:competitor:220602/profile.json?api_key=tvkmchnyurfvyez8jzv4hma4",
      //"http://api.sportradar.us/dota2-t1/en/players/sr:player:917768/profile.json?api_key=tvkmchnyurfvyez8jzv4hma4"
);
$sports=array("dota2-t1","csgo-t1","lol-t1","nfl","nba");
//gets tournament id for the esports
//no sport information needed from here
function tournamentarray($sport,$url,$keys){
  global $context;
  foreach($keys as $key){
      try{
          sleep(1);
          $json = json_decode(file_get_contents($url,true,$context));
          $returnval=array($sport=>array("tournamentsId"=>array()));
          //to limit api calls
          $tries=0;
          foreach($json->tournaments as $tournament){
              if($tries==3){break;}
              $tries+=1;
              if(!array_key_exists($tournament->id,$returnval[$sport]["tournamentsId"])){
              //if(!in_array($tournament->id,$returnval[$sport]["tournamentsId"])){
                array_push($returnval[$sport]["tournamentsId"],$tournament->id);
              }
          }
          break;
      }
      catch(Exception $e){
        continue;
      }
  }
}
function EsportTeams($sport,$tournamentIds,$keys){
  global $context;
  foreach($keys as $key){
      try{
          $tries=0;
          foreach($tournamentIds as $tournamentId){
              if($tries==1){break;}
              $tries+=1;
              sleep(1);
              $url= "http://api.sportradar.us/" . $sport . "/en/tournaments/" . $tournamentId . "/summaries.json?api_key=" . $key;
              $json = json_decode(file_get_contents($url,true,$context));
              foreach($json->summaries as $match){
                  foreach($match->sport_event->competitors as $team){
                      if(!array_key_exists($team->id,$returnval)){
                          $returnval[$team->id]= array("name"=>$team->name,"abbreviation"=>$team->abbreviation);
                      }
                  }
              }
          }
      }
      catch(Exception $e){
        continue;
      }
  }

}
/*function SportTeams($sport,$teamId,$tournamentId,$version,$keys){
    sleep(1);
    $returnval=array();

}*/
function player($teamId,$sport,$key){
    $returnval=array();

}
function playerstat($sport,$playerId,$key){
    sleep(1);
    return $returnval;
}
function populate(){
    global $sports,$keys,$context,$urls;
    $returnval=array();

    foreach($sports as $sport){
        if($sport!="lol-t1"){continue;}
        echo $sport;
        //each sport to be added to returnval;
        $add=array("sport"=>$sport, "teamsId"=>array());
        if($sport=="lol-t1" or $sport="dota2-t1" or $sport="csgo-t1"){
            //adds tournamentId for esport
            $add["tournamentsId"]=tournamentarray($sport,$urls[$sport],$keys[$sport]);
            $add["teamsId"]=EsportTeams($sport,$add["tournamentsId"],$keys[$sport]);
        }
        //in case we decide to include normal sports
        else{}
        foreach($add["teamsId"])


  //$jsonfile=fopen("data.json","w");
  //fwrite($jsonfile,json_encode($returnval));
  //fclose($jsonfile);
  }
}
populate();

?>
