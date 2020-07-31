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

    //Edit profile function
    function editProfile($Fullname, $email, $uname, $pw){
        if(!is_null($pw))
	    $pw = password_hash($pw, PASSWORD_DEFAULT);
        $mydb = dbConnect();
        $query = "UPDATE users SET ";
	if(!is_null($Fullname) && $Fullname!="")
		$query.=" fullname = '$Fullname'";
	if(!is_null($email) && $email!="")
		$query.=" email = '$email'";
	if(!is_null($pw) && $pw!="")
		$query.=" pw = '$pw'";
	$query.="WHERE username = '$uname';";
	echo $query;
        $response = mysqli_query($mydb, $query);
    	return true;
    }

    //searches for team in database and if exist then send team and players to APP
    function search($searchText){
        //if team hasnt been updated in a day it'll update it
    	  $mydb = dbConnect();
        $test="Hello PHP\n";
       	$test2="Hello PHP2\n";
      	$test3="Hello PHP3\n";
      	$test4="Hello PHP4\n";
      	$test5="Hello PHP5\n";
        $query="SELECT * FROM Teams WHERE Name='$searchText'";
        $result = $mydb->query($query);
        while($row = mysqli_fetch_array($result)){
            if($row[3]!=date("M d, Y")){
              echo "Team needs to be updated<br>";
              $request = array('type'=>"Search_Team",'TeamName'=>$searchText);
              $response=createClientForAPI($request);
              process($response);
              $date=date("M d, Y");
              $query="UPDATE Teams SET Created='$date' WHERE Name=$searchText";
              $result = $mydb->query($query);
            }
            else{
              echo "Team is already updated<br>";
            }
        }
        mysqli_free_result($result);
        $query = "SELECT Players.Name AS 'Player_Name', Teams.Name, Teams.Sport,Teams.ID FROM Players INNER JOIN Teams ON Players.Team_ID = Teams.ID WHERE Teams.Name = '$searchText';";

      	$response = $mydb->query($query);
       	$numRows = mysqli_num_rows($response);

      	$returnVal = "<h1>$searchText</h1>";
        $returnVal.="<button type='button' onclick='favoriteteam()'>Add Favorite Team</button>";
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
        echo "<br>Processing Json<br>";
        require_once("dbConnect.php");
        $mydb = dbConnect();
        $json=json_decode($response,true);
        //loops through each sport
        foreach($json as $sport){
            $sportName=$sport["sport"];
            $query = "SELECT * FROM Sports WHERE Name='$sportName'";
            $result=$mydb->query($query);
            //if sport exist insert if not do nothing
            if( mysqli_num_rows($result)==0){
              $query ="INSERT INTO Sports Values('$sportName')";
              $result=$mydb->query($query);
            }
            //see if sport has a teamsID
            if(array_key_exists("teamsId",$sport)){
                foreach(array_keys($sport["teamsId"]) as $teamId){
                    $teamName=$sport["teamsId"][$teamId]["name"];
                    $date=date("M d, Y");
                    $query="SELECT * FROM Teams WHERE ID='$teamId'";
                    $result=$mydb->query($query);
                    $rownum=mysqli_num_rows($result);
                    mysqli_free_result($result);
                    //if team doesn't exist insert into database else do nothing
                    if($rownum==0){
                      $query = "INSERT INTO Teams  Values ('$teamId','$teamName','$sportName','$date')";
                      $result=$mydb->query($query);
                    }
                    //loop over the player for each team
                    if(array_key_exists("players",$sport["teamsId"][$teamId])){
                        foreach(array_keys($sport["teamsId"][$teamId]["players"]) as $playerId){
                            $query = "SELECT * FROM Players WHERE ID='$playerId'";
                            $result=$mydb->query($query);
                            $rownum=mysqli_num_rows($result);
                            $playerName=$sport["teamsId"][$teamId]["players"][$playerId]["name"];
                            $nationality=$sport["teamsId"][$teamId]["players"][$playerId]["nationality"];
                            $birthday=$sport["teamsId"][$teamId]["players"][$playerId]["Birth_day"];
                            $gender=$sport["teamsId"][$teamId]["players"][$playerId]["gender"];
                            //if player exist update if needed else insert
                            if($rownum==0){
                              $query = "INSERT INTO Players Values ('$playerName','$playerId','$teamId','$nationality','$birthday','$gender')";
                              $result=$mydb->query($query);
                            }
                            else{
                              $query= "UPDATE Players SET ";
                              //comma check
                              $a=0;
                              $change=0;
                              while($row = mysqli_fetch_array($result)){
                                  if($row[3]==null and $nationality!=null){
                                    $query.= "nationality='$nationality',";
                                    $a=1;
                                    $change=1;
                                  }
                                  if($row[4]==null and $birthday!= null){
                                    $query.= "Birth_day='$birthday',";
                                    $a=1;
                                    $change=1;
                                  }
                                  if($row[5]==null and $gender!= null){
                                    $query.= "gender='$gender'";
                                    $a=0;
                                    $change=1;
                                  }
                              }
                              mysqli_free_result($result);
                              if($a==1){
                                //removes comma at end if it's there
                                $query=substr($query, 0, -1);
                              }
                              //update on players table is needed
                              if($change==1){
                                  $query.="WHERE ID='$playerId'";
                                  $result=$mydb->query($query);
                              }
                            }
                            if(array_key_exists("stats",$sport["teamsId"][$teamId]["players"][$playerId])){
                                $query="SELECT * FROM Esport_Stats WHERE Player_ID='$playerId'";
                                $result=$mydb->query($query);
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
                                $rownum=mysqli_num_rows($result);
                                if($rownum==0){
                                  $query="INSERT INTO Esport_Stats Values('$playerId',$maps_played,$maps_won,$maps_lost,$rounds_played,$rounds_won,$rounds_lost,$kills,$deaths,$assists,$headshots)";
                                  $result=$mydb->query($query);
                                }
                                else{
                                    $change=0;
                                    $a=0;
                                    $query="UPDATE Esport_Stats SET ";
                                    while($row = mysqli_fetch_array($result)){
                                      if($maps_played!=$row[1]){
                                        $query.="Maps_Played='$maps_played',";
                                        $a=1;
                                        $change=1;
                                      }
                                      if($maps_won!=$row[2]){
                                        $query.="Maps_Won='$maps_won',";
                                        $a=1;
                                        $change=1;
                                      }
                                      if($maps_lost!=$row[3]){
                                        $query.="Maps_Lost='$maps_lost',";
                                        $a=1;
                                        $change=1;
                                      }
                                      if($rounds_played!=$row[4]){
                                        $query.="Rounds_Played='$rounds_played',";
                                        $a=1;
                                        $change=1;
                                      }
                                      if($rounds_won!=$row[5]){
                                        $query.="Rounds_Won='$rounds_won',";
                                        $a=1;
                                        $change=1;
                                      }
                                      if($rounds_lost!=$row[6]){
                                        $query.="Rounds_Lost='$rounds_lost',";
                                        $a=1;
                                        $change=1;
                                      }
                                      if($kills!=$row[7]){
                                        $query.="Kills='$kills',";
                                        $a=1;
                                        $change=1;
                                      }
                                      if($deaths!=$row[8]){
                                        $query.="Deaths='$deaths',";
                                        $a=1;
                                        $change=1;
                                      }
                                      if($assists!=$row[9]){
                                        $query.="Assists='$assists',";
                                        $a=1;
                                        $change=1;
                                      }
                                      if($headshots!=$row[10]){
                                        $query.="Headshots='$headshots'";
                                        $a=0;
                                        $change=1;
                                      }
                                    }
                                    mysqli_free_result($result);
                                    if($a==1){
                                      //removes comma at end if it's there
                                      $query=substr($query, 0, -1);
                                    }
                                    //update on players table is needed
                                    if($change==1){
                                        $query.="WHERE Player_ID='$playerId'";
                                        $result=$mydb->query($query);
                                    }
                                }
                            }
                        }
                    }
                }
            }
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
        $response=createClientForAPI($request);
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
            $returnval.= "<div class='chatUser'>{$row[0]}</div>";
            $returnval.= "<div class='chatMessage'>{$row[1]}</div>";
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
          $query="INSERT INTO Favorite_Team (Username,TeamId) VALUES ('$username','$teamId')";
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
      $query="SELECT * FROM Favorite_Team INNER JOIN Teams WHERE Username='$user' AND Favorite_Team.TeamId=Teams.ID";
      //SELECT * FROM Favorite_Team INNER JOIN Players  WHERE Favorite_Team.TeamId=Players.Team_ID AND Username='jj356' ORDER by TeamId
      $result=$mydb->query($query);
      $teamIds=array();
      $returnval="";
      //inserts all teamsId for the favorited team for that user into a array
      while($row = mysqli_fetch_array($result)){
          //$row[1] is Team Id
          //$row[3] is Team Name
          $teamIds[$row[1]]=$row[3];
      }
      foreach(array_keys($teamIds) as $teamId){
        $query="SELECT * FROM Favorite_Team INNER JOIN Players INNER JOIN Esport_Stats  WHERE Favorite_Team.TeamId=Players.Team_ID AND Players.ID=Esport_Stats.Player_ID AND Username='$user' AND TeamId='$teamId'";
        $result=$mydb->query($query);
        $index=0;
        $returnval.="<div id='$teamId' class='FavoriteTeams'>";
        $returnval.="<h1>{$teamIds[$teamId]}</h1>";
        $returnval.="<button type='button' onclick=\"deleteFavorite(this)\">Delete Team</button>";
        $returnval.="<table border=1px style='width:100%'>";
        $returnval.="<tr>";
        $returnval.="<th>Player Name</th>";
        $returnval.="<th>Nationality</th>";
        $returnval.="<th>Birth Day</th>";
        $returnval.="<th>Gender</th>";
        $returnval.="<th>Maps Played</th>";
        $returnval.="<th>Maps Won</th>";
        $returnval.="<th>Maps Lost</th>";
        $returnval.="<th>Rounds Played</th>";
        $returnval.="<th>Rounds Won</th>";
        $returnval.="<th>Rounds Lost</th>";
        $returnval.="<th>Kills</th>";
        $returnval.="<th>Deaths</th>";
        $returnval.="<th>Assists</th>";
        $returnval.="<th>Headshots</th>";

        $returnval.="</tr>";
        while($row = mysqli_fetch_array($result)){
          $returnval.="<tr>";
          $returnval.="<td>" . $row[2] . "</td>";//Player Name
          $returnval.="<td>" . $row[5] . "</td>";//Nationality
          $returnval.="<td>" . $row[6] . "</td>";//birthday
          $returnval.="<td>" . $row[7] . "</td>";//gender
          $returnval.="<td>" . $row[9] . "</td>";//maps played
          $returnval.="<td>" . $row[10] . "</td>";//maps won
          $returnval.="<td>" . $row[11] . "</td>";//maps lost
          $returnval.="<td>" . $row[12] . "</td>";//rounds played
          $returnval.="<td>" . $row[13] . "</td>";//rounds won
          $returnval.="<td>" . $row[14] . "</td>";//rounds lost
          $returnval.="<td>" . $row[15] . "</td>";//kills
          $returnval.="<td>" . $row[16] . "</td>";//deaths
          $returnval.="<td>" . $row[17] . "</td>";//assists
          $returnval.="<td>" . $row[18] . "</td>";//headshots

          $returnval.="</tr>";
        }
        $returnval.="</table></div>";
      }
      if($returnval==""){
        return "EMPTY";
      }
      else{
      return $returnval;}
    }
    echo FavoriteTeam("testUser");
?>
