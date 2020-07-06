<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
function process($response){
    $change=0;
    require_once("connection.php");
    if(file_exists("saved.json")){
        $saved=json_decode(file_get_contents("saved.json"),true);
        //change back later
        $json=json_decode($response,true);
        $index=0;
        //loop through each sport
        foreach($saved as $sport){
            //loops through each team in that sport
            foreach(array_keys($sport["teamsId"]) as $teamId){
                //checks if their are players in that team
                if(array_key_exists("players",$sport["teamsId"][$teamId])){
                    //loops though each player
                    foreach(array_keys($sport["teamsId"][$teamId]["players"]) as $playerId){
                        //check if that player has stats
                        if(array_key_exists("stats",$sport["teamsId"][$teamId]["players"][$playerId])){
                            //loop through each stat and look for changes
                            foreach(array_keys($sport["teamsId"][$teamId]["players"][$playerId]["stats"]) as $statname){
                                //check if two stats are different and if they are change it
                                if($statname=="last_updated"){continue;}
                                if($sport["teamsId"][$teamId]["players"][$playerId]["stats"][$statname]!=$json[$index]["teamsId"][$teamId]["players"][$playerId]["stats"][$statname]){
                                    $change=1;
                                    $query="UPDATE ";
                                    $changevalue=$json[$index]["teamsId"][$teamId]["players"][$playerId]["stats"][$statname];
                                    if($sport["sport"]=="lol-t1" or $sport["sport"]=="csgo-t1" or $sport["sport"]=="dota2-t1"){
                                        $query.="Esport_Stats ";
                                    }
                                    else{
                                        $query.="Sport_Stats ";
                                    }
                                    $query.= "SET $statname=$changevalue WHERE Player_ID='$playerId'";
                                    $result=mysqli_query($con,$query);
                                }
                            }
                        }
                    }
                }
            }
            $index+=1;
        }
    }
    else{
        $json=json_decode($response,true);
        //add every sport into database
        foreach($json as $sport){
            $sportName=$sport["sport"];
            $query ="INSERT INTO Sports Values('$sportName')";
            $result=mysqli_query($con,$query);
            //add every  team into teamId
            if(array_key_exists("teamsId",$sport)){
                foreach(array_keys($sport["teamsId"]) as $teamId){
                    $teamName=$sport["teamsId"][$teamId]["name"];
                    $query = "INSERT INTO Teams Values ('$teamId','$teamName','$sportName')";
                    $result=mysqli_query($con,$query);
                    //add every player
                    if(array_key_exists("players",$sport["teamsId"][$teamId])){
                        foreach(array_keys($sport["teamsId"][$teamId]["players"]) as $playerId){
                            $playerName=$sport["teamsId"][$teamId]["players"][$playerId]["name"];
                            $query="INSERT INTO Players Values('$playerName','$playerId','$teamId')";
                            $result=mysqli_query($con,$query);
                            if(array_key_exists("stats",$sport["teamsId"][$teamId]["players"][$playerId])){
                                $query="INSERT INTO ";
                                if($sportName=="lol-t1" or $sportName=="dota2-t1" or $sportName="csgo-t1"){
                                    $maps_played=$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["maps_played"];
                                    $maps_won=$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["maps_won"];
                                    $maps_lost=$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["maps_lost"];
                                    $rounds_played=$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["rounds_played"];
                                    $rounds_won=$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["rounds_won"];
                                    $rounds_lost=$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["rounds_lost"];
                                    $kills=$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["kills"];
                                    $deaths=$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["deaths"];
                                    $assists=$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["assists"];
                                    $headshots=$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["headshots"];
                                    $query.="Esport_Stats Values('$playerId',$maps_played,$maps_won,$maps_lost,$rounds_played,$rounds_won,$rounds_lost,$kills,$deaths,$assists,$headshots)";
                                }
                                else{
                                    $query.="Sport_Stats ";
                                }
                                $result=mysqli_query($con,$query);
                            }
                        }
                    }
                }
            }
            $change=1;
        }
    }
    if($change==1){
      $jsonfile=fopen("saved.json","w");
      fwrite($jsonfile,json_encode($json));
      fclose($jsonfile);
    }
}
?>
