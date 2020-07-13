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
      	$returnVal.="<table border=1px style='width:100%'>";
      	$returnVal.="<tr>";
      	$returnVal.="<th>Player</th>";
     	  $returnVal.="<th>Team</th>";
      	$returnVal.="<th>Sport</th>";
      	$returnVal.="</tr>";
        $num=0;
        $size=0;
      	while($responseArray = mysqli_fetch_array($response)){
              $size+=1;
              if($num==0){
                $returnval.= "<input type="hidden" id='teamId' value='$responseArray[3]'>";
              }
    	        $returnVal.="<tr>";
              $returnVal.="<td>" . $responseArray[0] . "</td>";
              $returnVal.="<td>" . $responseArray[1] . "</td>";
              $returnVal.="<td>" . $responseArray[2] . "</td>";
              $returnVal.="</tr>";
              $num+=1;
      	}
        if($size!=0){
		        return $returnVal;
        }
        else {return "";}
    }
    //checks if database if populated else gets information from API
    function populate(){
    }
    //send message to database
    function sendMessage($username,$message){

    }
    //return messages for APP
    function update(){}
    //add favorite or deletes
    function AddFavorite($username,$teamId,$action){}
    //prints out favorite team for a user
    function FavoriteTeam($user){}
?>
