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
        $mydb = dbConnect();
        $query="INSERT INTO chat (Username,Message) VALUES ('$username','$message')";
        $response = $mydb->query($query);
        $result=mysqli_query($con,$query);
        return "";
    }
    //return messages for APP
    function update(){
        $mydb = dbConnect();
        $query="SELECT * FROM chat";
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
    //add favorite or deletes
    //not done
    function AddFavorite($username,$teamId,$action){
      $mydb = dbConnect();
      if($action=="add"){
          $query="INSERT INTO Favorite (Username,TeamId) VALUES ('$username','$message')";
      }
      else{
        $query="DELETE FROM Favorite WHERE Username='$username' AND TeamId='$teamId'";
      }
      $response = $mydb->query($query);
    }
    //prints out favorite team for a user
    //not done
    function FavoriteTeam($user){
      $mydb = dbConnect();
      $query="SELECT * FROM Favorite  WHERE username='$user'";
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
