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
    "nfl"=>"wdyztaakwe8sny3vb4prt863",
    "nba"=>"nyfttfgabf7hq86m79kmxjy4",
    "lol-t1"=>"h5cp8u2nzqghgj7hzvwr9k8q",
    "csgo-t1"=>"rk7326buc7aqc72qtsudr3pv",
    "dota2-t1"=>"6h36hmhscj2z34x4bdj6w2a3",
    "mlb"=>"2ftdna96n3yx6q9rkekbrbbc"
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
      //"http://api.sportradar.us/csgo-t1/en/tournaments/sr:tournament:2390/summaries.json?api_key=rxnve45j95ac742auc5xt329",
      //"http://api.sportradar.us/csgo-t1/en/teams/sr:competitor:220602/profile.json?api_key=rxnve45j95ac742auc5xt329",
      //"http://api.sportradar.us/csgo-t1/en/players/sr:player:917768/profile.json?api_key=rxnve45j95ac742auc5xt329"
    ,
  "dota2-t1"=>"http://api.sportradar.us/dota2-t1/en/tournaments.json?api_key=6h36hmhscj2z34x4bdj6w2a3"
      //"http://api.sportradar.us/dota2-t1/en/tournaments.json?api_key=tvkmchnyurfvyez8jzv4hma4"
      //"http://api.sportradar.us/dota2-t1/en/tournaments/sr:tournament:14029/summaries.json?api_key=tvkmchnyurfvyez8jzv4hma4",
      //"http://api.sportradar.us/dota2-t1/en/teams/sr:competitor:220602/profile.json?api_key=tvkmchnyurfvyez8jzv4hma4",
      //"http://api.sportradar.us/dota2-t1/en/players/sr:player:917768/profile.json?api_key=tvkmchnyurfvyez8jzv4hma4"
    ,
  "mlb"=>"http://api.sportradar.us/mlb/trial/v6.6/en/teams/aa34e0ed-f342-4ec6-b774-c79b47b60e2d/profile.json?api_key=2ftdna96n3yx6q9rkekbrbbc"
      //"http://api.sportradar.us/mlb/trial/v6.6/en/players/6e1cac5c-b059-4b80-a267-5143b19efb27/profile.json?api_key=2ftdna96n3yx6q9rkekbrbbc"
);
$sports=array("dota2-t1","csgo-t1","lol-t1","nfl","nba","mlb");
$returnval=array();
//gets tournament id for the esports
//no sport information needed from here
function tournamentarray($url,$sport,$key){
  sleep(1);
  $json = json_decode(file_get_contents($url,true,$context));
  $returnval=array($sport=>array("tournamentsId"=>array()));
  //to limit api calls
  $tries=0;
  foreach($json->tournaments as $tournament){
      if($tries==1){break;}
      $tries+=1;
      if(!array_key_exists($tournament->id,$returnval[$sport]["tournamentsId"])){
      //if(!in_array($tournament->id,$returnval[$sport]["tournamentsId"])){
        array_push($returnval[$sport]["tournamentsId"],$tournament->id);
      }
  }
  /* for testing
  if(file_exists("tournaments.json")){
      $jsonfile=json_decode(file_get_contents("tournaments.json"),true);
      if(!array_key_exists($sport,$returnval)){
          $jsonfile[$sport]=$returnval;
          //array_push($jsonfile,$returnval);
          file_put_contents("tournaments.json",json_encode($jsonfile));
      }
  }
  else{
      $jsonfile=fopen("tournaments.json","w");
      fwrite($jsonfile,json_encode($returnval));
      fclose($jsonfile);
  }*/
  return $returnval;
}
//tournamentId is for Sport
//version is for normal sports
function teamsarray($sport,$teamId,$tournamentId,$version,$keys){
    sleep(1);
    $returnval=array();
    //for esports
    if($sport=="lol-t1" or $sport=="csgo-t1" or $sport="dota2-t1"){
      $tries=0;
      foreach($tournamentId as $tournament){
        if($tries==1){break;}
        $tries+=1;
        $url ="http://api.sportradar.us/" . $sport . "/en/tournaments/" . $tournament . "/summaries.json?api_key=" . $keys[$sport];
        sleep(1);
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
    //for normal sports
    else{}
    /* for testing
    if(file_exists("teams.json")){
        $jsonfile=json_decode(file_get_contents("teams.json"),true);
        if(!array_key_exists($sport,$returnval)){
            $jsonfile[$teamId]=$returnval;

        }
        //array_push($jsonfile,$returnval);
        file_put_contents("teams.json",json_encode($jsonfile));
    }
    else{
        $jsonfile=fopen("teams.json","w");
        fwrite($jsonfile,json_encode($returnval));
        fclose($jsonfile);
    }*/
    return $returnval;
}
function player($teamId,$sport,$key){
    $returnval=array();
    sleep(1);
    $url="http://api.sportradar.us/" . $sport . "/en/teams/" . $teamId . "/profile.json?api_key=" . $key ;
    $json = json_decode(file_get_contents($url,true,$context));
    $tries=0;
    foreach($json->players as $player){
        if($tries==12){break;}
        $tries+=1;
        if(!array_key_exists($player->id,$returnval)){
            $returnval[$player->id]=array("name"=>$player->name,"Birth_day"=>$player->date_of_birth,"nationality"=>$player->nationality,"gender"=>$player->gender);

        }
    }
    /*
    if(file_exists("playersssss.json")){
        $jsonfile=json_decode(file_get_contents("teams.json"),true);
        $jsonfile[$teamId]=$returnval;
        //array_push($jsonfile,$returnval);
        file_put_contents("players.json",json_encode($jsonfile));
    }
    else{
        $jsonfile=fopen("players.json","w");
        fwrite($jsonfile,json_encode($returnval));
        fclose($jsonfile);
    }*/
    return $returnval;

}
function playerstat($sport,$playerId,$key){
    sleep(1);
    $url="http://api.sportradar.us/" . $sport . "/en/players/" . $playerId . "/profile.json?api_key=" . $key ;
    $json = json_decode(file_get_contents($url,true,$context));
    if($sport=="lol-t1" or $sport=="csgo-t1" or $sport="dota2-t1"){
        $returnval=array("last_updated"=>$json->generated_at,"maps_played"=>0,"maps_won"=>0,"maps_lost"=>0,"rounds_played"=>0,"rounds_won"=>0,"rounds_lost"=>0,"kills"=>0,"deaths"=>0,"assists"=>0,"headshots"=>0);
        foreach($json->statistics as $stats){
            foreach(array_keys($returnval) as $stat){
                if($stats->$stat>$returnval[$stat]){
                  $returnval[$stat]=$stats->$stat;
                }
            }
        }
    }
    else{}
    //for testing
    /*
    if(file_exists("statsssssss.json")){
        $jsonfile=json_decode(file_get_contents("teams.json"),true);
        $jsonfile[$teamId]=$returnval;
        file_put_contents("players.json",json_encode($jsonfile));
    }
    else{
        $jsonfile=fopen("stats.json","w");
        fwrite($jsonfile,json_encode($returnval));
        fclose($jsonfile);
    }*/
    return $returnval;
}
if(file_exists("data.json")==true){
    $data=json_decode(file_get_contents("data.json"),true);
    //data.json exist but no data inside
    if(count($data)<1){
      unlink("data.json");
    }
    else{
        foreach($data as $sport){
            //cleaning empty items
            if($sport["sport"]=="lol-t1" or $sport=="csgo-t1" or $sport=="nfl" or $sport=="nba" or $sport="mlb"){continue;}
              //add tournamentId if it's empty only for esports is it needed
            if(/*$sport["sport"]=="csgo-t1" or $sport["sport"]=="lol-t1or*/ $sport["sport"]== "csgo-t1"){
                    /*echo $sport["sport"] . "<br>";
                    if(count($sport["tournamentId"])==0){
                        $sport["tournamentId"]=tournamentarray($urls[$sport["sport"]],$sport["sport"],$keys[$sport["sport"]])[$sport]["tournamentsId"];
                    }
                    //adds teams if it's empty
                    if(count($sport["teamsId"])==0){
                        //$data[""]
                        $sport["teamsId"]=teamsarray($sport["sport"],"",$sport["tournamentId"],"",$keys[$sport["sport"]]);
                    }
                    //add players if it's empty
                    foreach(array_keys($sport["teamsId"]) as $teamId){
                            if(!key_exists("players",$sport["teamsId"][$teamId])){
                            //if(count($sport["teamsId"][$teamId]["players"])==0)
                                $sport["teamsId"][$teamId]["players"]=player($teamId,$sport["sport"],$keys[$sport["sport"]]);
                            }
                    }
                    //adds player stat if it's empty
                    foreach(array_keys($sport["teamsId"]) as $teamId){
                        //if team has players in it
                        if(key_exists("players",$sport["teamsId"][$teamId])){
                            $tries=0;
                            foreach(array_keys($sport["teamsId"][$teamId]["players"]) as $playerId){
                                //echo $playerId . "<br>";
                                if($tries==1){break;}
                                $tries+=1;
                                if(key_exists("stats",$sport["teamsId"][$teamId]["players"][$playerId])){
                                    $sport["teamsId"][$teamId]["players"][$player]["stats"]=playerstat($sport["sport"],$playerId,$keys[$sport["sport"]]);
                                }
                            }
                        }
                    }
              }
            //for normal sports
              else{}*/
              }

        }
        $jsonfile=fopen("data2.json","w");
        fwrite($jsonfile,json_encode($data));
        fclose($jsonfile);
    }
}
else{
    foreach($sports as $sport){
        //if($sport!="csgo-t1" ){continue;}
        if($sport=="nfl" or $sport=="nba" or $sport=="mlb"){continue;}
        $add=array("sport"=>$sport, "teamsId"=>array());
        if($sport=="lol-t1" or $sport=="dota2-t1" or $sport=="csgo-t1" ){
            //adds tournamentId
            $add["tournamentId"]=tournamentarray($urls[$sport],$sport,$keys[$sport])[$sport]["tournamentsId"];
            //add TeamId
            $add["teamsId"]=teamsarray($sport,"",$add["tournamentId"],"",$keys);
            //add players to each TeamId
            $tries=0;
            foreach(array_keys($add["teamsId"]) as $teamId){
              if($tries==1){break;}
              $tries+=1;
              $add["teamsId"][$teamId]["players"]=player($teamId,$sport,$keys[$sport]);
            }
            //add player stats for players
            $tries=0;
            foreach(array_keys($add["teamsId"]) as $teamId){
                if($tries>=1){break;}
                foreach(array_keys($add["teamsId"][$teamId]["players"]) as $playerId){
                    if($tries>=1){break;}
                    $tries+=1;
                    $add["teamsId"][$teamId]["players"][$playerId]["stats"]=playerstat($sport,$playerId,$keys[$sport]);
                }
            }
        }
        else{
        }
        //print thing out

        array_push($returnval,$add);
    }
    $jsonfile=fopen("data.json","w");
    fwrite($jsonfile,json_encode($returnval));
    fclose($jsonfile);
}
?>
