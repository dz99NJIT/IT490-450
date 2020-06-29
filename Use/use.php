<?php
    require_once("connection.php");
    //$query="SELECT * FROM Realtor ";
    //$result=mysqli_query($con,$query);
    if(file_exists("dataaa.json")){

    }
    else{
        $json=json_decode(file_get_contents("data.json"),true);
        //add every sport into database
        foreach($json as $sport){
            $sportName=$sport["sport"];
            $query ="INSERT INTO Sports Values('$sportName')";
            $result=mysqli_query($con,$query);
            //add every  team into teamId
            foreach(array_keys($sport["teamsId"]) as $teamId){
                $teamName=$sport["teamsId"][$teamId]["name"];
                $query = "INSERT INTO Teams Values ('$teamId','$teamName','$sportName')";
                $result=mysqli_query($con,$query);
                //add every player
                foreach(array_keys($sport["teamsId"][$teamId]["players"]) as $playerId){
                    $query="INSERT INTO ";
                    if($sportName=="lol-t1" or $sportName=="dota2-t1" or $sportName=="csgo-t1"){
                      $name=$sport["teamsId"][$teamId]["players"][$playerId]["name"];
                      $id=$playerId;
                      $last_updated=($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["last_updated"]==null)?"":$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["last_updated"];
                      $maps_played=($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["maps_played"]==null) ? 0:$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["maps_played"]=="";
                      $maps_won=($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["maps_won"]==null)?0:$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["maps_won"];
                      $maps_lost=($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["maps_lost"]==null)?0:$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["maps_lost"];
                      $rounds_played=($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["rounds_played"]==null)?0:$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["rounds_played"];
                      $rounds_won=($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["rounds_won"]==null)?0:$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["rounds_won"];
                      $rounds_lost=($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["rounds_lost"]==null)?0:$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["rounds_lost"];
                      $kills=($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["kills"]==null)?0:$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["kills"];
                      $deaths=($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["deaths"]==null)?0:$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["deaths"];
                      $assists = ($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["assists"]==null)?0:$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["assists"];
                      $heashots = ($sport["teamsId"][$teamId]["players"][$playerId]["stats"]["headshots"]==null)?0:$sport["teamsId"][$teamId]["players"][$playerId]["stats"]["headshots"];
                      $query.="Player Values('$name','$id','$teamId','$last_updated',$maps_played,$maps_won,$maps_lost,$rounds_played,$rounds_won,$rounds_lost,$kills,$deaths,$assists,$heashots)";
                    }
                    echo gettype($kills);
                    $result=mysqli_query($con,$query);
                }
            }

        }
    }
    echo "done";
?>
