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
    "dota2-t1"=>array("ery3xdx8q5kntawq58g9e5zz")
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
          sleep(1);
          $json = json_decode(file_get_contents($url,true,$context));
          $returnval=array($sport=>array("tournamentsId"=>array()));
          //to limit api calls
          $tries=0;
          foreach($json->tournaments as $tournament){
              if($tries==2){break;}
              $tries+=1;
              if(!array_key_exists($tournament->id,$returnval[$sport]["tournamentsId"])){
              //if(!in_array($tournament->id,$returnval[$sport]["tournamentsId"])){
                array_push($returnval[$sport]["tournamentsId"],$tournament->id);
              }
          }
          return $returnval[$sport]["tournamentsId"];
  }
}
function EsportTeams($sport,$tournamentIds,$keys){
  global $context;
  foreach($keys as $key){
      try{
          $returnval=array();
          foreach($tournamentIds as $tournamentId){
              sleep(1);
              $url= "http://api.sportradar.us/" . $sport . "/en/tournaments/" . $tournamentId . "/summaries.json?api_key=" . $key;
              $json = json_decode(file_get_contents($url,true,$context))  or exit("erro at line 56");
              foreach($json->summaries as $match){
                  foreach($match->sport_event->competitors as $team){
                      if(!array_key_exists($team->id,$returnval)){
                          $returnval[$team->id]= array("name"=>$team->name,"abbreviation"=>$team->abbreviation);
                      }
                  }
              }
          }
          return $returnval;
      }
      catch(Exception $e){
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        continue;
      }
  }

}
function player($teamId,$sport,$keys){
    //adds player for a team
    global $context;
    $returnval=array();
    foreach($keys as $key){
        try{
            if($sport=="lol-t1" or $sport=="dota2-t1" or $sport=="csgo-t1"){
              $url="http://api.sportradar.us/" . $sport . "/en/teams/" . $teamId . "/profile.json?api_key=" . $key ;
              $json = json_decode(file_get_contents($url,true,$context));
              echo $url;
              $tries=0;
              foreach($json->players as $player){
                  if(!array_key_exists($player->id,$returnval)){
                      $returnval[$player->id]=array("name"=>$player->name,"Birth_day"=>$player->date_of_birth,"nationality"=>$player->nationality,"gender"=>$player->gender);
                  }
              }
            }
            //for normal sports if group decides to add
            else{}
            return $returnval;
        }
        catch(Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return 0;
            continue;
        }
    }
    return $returnval;
}
function populate(){
    global $sports,$keys,$context,$urls;
    $returnval=array();
    foreach($sports as $sport){
        if($sport=="nba" or $sport=="nfl"){continue;}
        echo $sport;
        //each sport to be added to returnval;
        $add=array("sport"=>$sport, "teamsId"=>array());
        if($sport=="lol-t1" or $sport="dota2-t1" or $sport="csgo-t1"){
            //adds tournamentId for esport
            $add["tournamentsId"]=tournamentarray($sport,$urls[$sport],$keys[$sport]);
            //adds teams Id for each sport by using tournament Id
            $add["teamsId"]=EsportTeams($sport,$add["tournamentsId"],$keys[$sport]);
        }
        //in case we decide to include normal sports
        else{}
        //loops through team
        foreach(array_keys($add["teamsId"]) as $teamId){
            //adds players to each team
            $add["teamsId"][$teamId]["players"]=player($teamId,$sport,$keys[$sport]);
            //adds player stats
            foreach(array_keys($add["teamsId"][$teamId]["players"]) as $playerId){
                $add["teamsId"][$teamId]["players"][$playerId]["stats"]=array();
            }
        }
        array_push($returnval,$add);
  }
  $jsonfile=fopen("data.json","w");
  fwrite($jsonfile,json_encode($returnval));
  fclose($jsonfile);
  return json_encode($returnval);
}
function playerstat($sport,$playerId){
    global $context,$keys;
    $keyvalues=$keys[$sport];
    if(file_exists("data.json")){
        foreach($keyvalues as $key){
            try{
              sleep(1);
              $url="http://api.sportradar.us/" . $sport . "/en/players/" . $playerId . "/profile.json?api_key=" . $key ;
              echo $url . "<br>";
              $json = json_decode(file_get_contents($url,true,$context),true);
              $jsonfile= json_decode(file_get_contents("data.json"),true);
              if($sport=="lol-t1" or $sport=="csgo-t1" or $sport="dota2-t1"){
                  $returnval=array("last_updated"=>date("M d, Y"),"maps_played"=>0,"maps_won"=>0,"maps_lost"=>0,"rounds_played"=>0,"rounds_won"=>0,"rounds_lost"=>0,"kills"=>0,"deaths"=>0,"assists"=>0,"headshots"=>0);
                  //checks to see if that player has any stats
                  if(isset($json->statistics)){
                    foreach($json->statistics as $stats){
                        foreach(array_keys($returnval) as $stat){
                            if($stats->$stat>$returnval[$stat]){
                              $returnval[$stat]=$stats->$stat;
                            }
                        }
                    }
                  }
                  //looks for right sport
                  $index=0;
                  foreach($jsonfile as $sportArray){
                      //check if it's the right sport
                      if($sportArray["sport"]==$sport){
                          foreach(array_keys($sportArray["teamsId"]) as $teamId){
                              foreach(array_keys($sportArray["teamsId"][$teamId]["players"]) as $playerId2){
                                  if($playerId==$playerId2){
                                      $jsonfile[$index]["teamsId"][$teamId]["players"][$playerId2]["stats"]=$returnval;
                                      $file=fopen("data.json","w");
                                      fwrite($file,json_encode($jsonfile));
                                      fclose($file);
                                  }
                              }
                          }
                      }
                      $index+=1;
                  }
              }
              //if we decide to also include normal sports
              else{}

            }
            catch(Exception $e){
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                continue;
            }
        }
    }
    else{
        echo "ERROR: data.json doing exist!!!!";
    }
}
function Search_Player($name){
    if(file_exists("data.json")){
        $json=json_decode(file_get_contents("data.json"),true);
        foreach ($json as $sport){
            $sportname=$sport["sport"];
            foreach(array_keys($sport["teamsId"]) as $teamId){
                //checks if team has players
                if(array_key_exists("players", $sport["teamsId"][$teamId])){
                    foreach(array_keys($sport["teamsId"][$teamId]["players"]) as $playerId){
                        if($sport["teamsId"][$teamId]["players"][$playerId]["name"]==$name){
                            //checks if player has stats
                            if(array_key_exists("stats",$sport["teamsId"][$teamId]["players"][$playerId])){
                                //check if player stats has the last_updated attribute
                                if(array_key_exists("last_updated",$sport["teamsId"][$teamId]["players"][$playerId]["stats"])){
                                    $timediff=strtotime(date("M d, Y")) - strtotime($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["last_updated"]);
                                    //updates only if atleast a day old
                                    if($timediff!=0){
                                        playerstat($sportname,$playerId);
                                    }
                                }
                                else{
                                    playerstat($sportname,$playerId);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    else{
      echo "ERROR: data.json doing exist!!!!";
    }
}
function Search_Team($name){
  if(file_exists("data.json")){
      $json=json_decode(file_get_contents("data.json"),true);
      $index=0;
      global $keys;
      foreach ($json as $sport){
          $sportname=$sport["sport"];
          foreach(array_keys($sport["teamsId"]) as $teamId){
              //checks if team has players
              if($sport["teamsId"][$teamId]["name"]==$name){
                  if(array_key_exists("players", $sport["teamsId"][$teamId]) and count($sport["teamsId"][$teamId]["players"])>0){
                      foreach($sport["teamsId"][$teamId]["players"] as $player){
                          Search_Player($player["name"]);
                      }
                  }
                  else{
                      $json[$index]["teamsId"][$teamId]["players"]=player($teamId,$sportname,$keys[$sportname]);
                      $jsonfile=fopen("data4.json","w");
                      fwrite($jsonfile,json_encode($json));
                      fclose($jsonfile);
                      Search_Team($name);
                  }
              }
          }
          $index+=1;
      }
  }
  else{
    echo "ERROR: data.json doing exist!!!!";
  }
}
?>
