<?php
session_start();
//require_once('functions.php');
	//loggedCheck();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src=landingPage.js></script>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
	<a class="navbar-brand" href="landingPage.php">SportWatch</a>
  	<ul class="navbar-nav">
   		<li class="nav-item active">
    		<a class="nav-link" href="landingPage.php">Home</a>
			</li>
			<li class="nav-item active">
      	<a class="nav-link" href="events.php">Events</a>
    	</li>
  	</ul>
  	<ul class="navbar-nav ml-auto">
   		<form class="form-inline" action="cases.php" method="POST">
		<input type="hidden" id="type" name="type" value="Search">
     		<input class="form-control mr-sm-2" type="text" id='searchText" placeholder="Search for Teams">
     		<button class="btn btn-success" type="submit">Search</button>
   		</form>
			<a class="navbar-brand pl-4" href="profile.php">
   			<img src="person.png" alt="logo" style="width:40px;">
  		</a>
  		<li class="nav-item active">
   			<a class="nav-link" href="logout.php">Logout</a>
 			</li>
		</ul>
</nav>
<br><br><br>

<div class="container-fluid">
	 <?php $uname = $_SESSION["uname"]; echo "<h1>Welcome $uname</h1>"; ?>
</div>
	<button type="button" value= "espn" onclick="buttonclick(this)">ESPN</button>
	<button type="button" value= "lol" onclick="buttonclick(this)">League Of Legends</button>
	<button type="button" value="csgo"onclick="buttonclick(this)">Counter-Strike: Global Offensive</button>
	<button type="button" value="dota2" onclick="buttonclick(this)">DOTA2</button>

	<div id="espn" class="sportNews">
			<a id="espn" class="twitter-timeline" href="https://twitter.com/espn?ref_src=twsrc%5Etfw">ESPN</a>
			<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>
	<div id="lol" class="sportNews">
			<a id= "lol" class="twitter-timeline" href="https://twitter.com/LCSOfficial?ref_src=twsrc%5Etfw">Tweets by LCSOfficial</a>
			<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>
	<div id="csgo" class="sportNews">
			<a id="csgo" class="twitter-timeline" href="https://twitter.com/ESLCS?ref_src=twsrc%5Etfw">Tweets by ESLCS</a>
			<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>	
	<div id ="dota2" class="sportNews">
			<a id= "dota2" class="twitter-timeline" href="https://twitter.com/ESLDota2?ref_src=twsrc%5Etfw">Tweets by ESLDota2</a>
			<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
	</div>
</body>
</html>
