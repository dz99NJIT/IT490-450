<?php

    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('AppRabbitMQClient.php');
    require_once('dbConnect.php');

    //Login function
    function doLogin($uname, $pw){
        $mydb = dbConnect();
        $query = "select pw from users where username = '$uname';";
	      $response = $mydb->query($query);
 	      $numRows = mysqli_num_rows($response);
	      $responseArray = $response -> fetch_assoc();
        if ($numRows>0){
        		if(password_verify($pw, $responseArray['pw']))
        		{
        			return true;
        		}
        		else
        		{
        			return false;
        		}
        		return true;
        }
        else
        {
            return false;
        }
    }
    //Sign up function
    function signUp($Fullname,$email, $uname, $pw){
        $pw = password_hash($pw, PASSWORD_DEFAULT);
        $key = md5(time().$uname);
        $mydb = dbConnect();
        $query = "INSERT INTO `users`(`fullname`, `email`, `username`, `pw`, `verificationkey`) VALUES ('$Fullname','$email','$uname','$pw', '$key');";
        //$query = "insert into users values ('$Fullname', '$uname', '$pw');";
        $response = mysqli_query($mydb, $query);
    	  return true;
    }
    //searches for team in database and if exist then send team and players to APP
    function search($searchText){
        $mydb = dbConnect();

        $query = "SELECT Players.Name AS 'Player_Name', Teams.Name, Teams.Sport,Teams.ID FROM Players INNER JOIN Teams ON Players.Team_ID = Teams.ID WHERE Teams.Name = '$searchText';";

      	$response = $mydb->query($query);
       	$numRows = mysqli_num_rows($response);

      	$returnVal = "<h1>$searchText</h1>";
        $returnVal.="<button type='button' onclick='favoriteteam($searchText)'>Click Me!</button>";
      	$returnVal.="<table border=1px style='width:100%'>";
      	$returnVal.="<tr>";
      	$returnVal.="<th>Player</th>";
     	  $returnVal.="<th>Team</th>";
      	$returnVal.="<th>Sport</th>";
      	$returnVal.="</tr>";
        $num=0;
      	while($responseArray = mysqli_fetch_array($response)){
              if($num==0){
                $returnVal.= "<input type='hidden' id='teamId' value='$responseArray[3]'>";
              }
    	        $returnVal.="<tr>";
              $returnVal.="<td>" . $responseArray[0] . "</td>";
              $returnVal.="<td>" . $responseArray[1] . "</td>";
              $returnVal.="<td>" . $responseArray[2] . "</td>";
              $returnVal.="</tr>";
              $num+=1;
      	}
        if($numRows!=0){
		        return $returnVal;
        }
        else {return "";}
    }
    //process json file from API and adds to database
    //if data already exist update it
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
    //checks if database if populated else gets information from API
    function populate(){
      $mydb = dbConnect();
      $query="SELECT * FROM Teams";
      $response = $mydb->query($query);
      $numRows = mysqli_num_rows($response);
      if($numRows==0){
        $request=array("type"=>"populate");
        $response=createClientForDb($request);
        process($response);
        return "Database has been Populated";
      }
      else{
        return "Database already populated";
      }
    }

    //send message to database
    function sendMessage($username,$message){
        $mydb = dbConnect();
        $query="INSERT INTO Chat (Username,Message) VALUES ('$username','$message')";
        $response = $mydb->query($query);
        $result=mysqli_query($con,$query);
        return "";
    }
    //return messages for APP
    function update(){
        $mydb = dbConnect();
        $query="SELECT * FROM Chat";
        $result=$mydb->query($query);
        $returnval="";
        $index=0;
        while($row = mysqli_fetch_array($result)){
            if($index==20){
              break;
            }
            $returnval.="<div class='chat'>";
            $returnval.= "<div class='chatUser'>{$row[0]} </div>";
            $returnval.= "<div class='chatMessage'>{$row[1]} </div>";
            $returnval.= "</div>";
            $index+=1;
        }
        return $returnval;
    }
    //add favorite or deletes
    //not done
    function AddFavorite($username,$teamId,$action){
      $mydb = dbConnect();
      if($action=="add"){
          $query="INSERT INTO Favorite_Team (Username,TeamId) VALUES ('$username','$message')";
      }
      else{
        $query="DELETE FROM Favorite_Team WHERE Username='$username' AND TeamId='$teamId'";
      }
      $response = $mydb->query($query);
    }
    //prints out favorite team for a user
    //not done
    function FavoriteTeam($user){
      $mydb = dbConnect();
      $query="SELECT * FROM Favorite_Team  WHERE Username='$user'";
      $result=$mydb->query($query);
      $returnval="";
      $index=0;
      while($row = mysqli_fetch_array($result)){
          if($index==20){break;}
          $returnval.="<div class='chat'>";
          $returnval.= "<div>{$row[0]} </div>";
          $returnval.= "<div>{$row[1]} </div>";
          $returnval.= "</div>";
          $index+=1;
      }
      return $returnval;
    }
?>
