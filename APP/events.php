<?php
session_start();
require_once('functions.php');
	//loggedCheck();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!--	<script src=landingPage.js></script>     -->
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
   		<form class="form-inline" action="teamSearch.php">
     		<input class="form-control mr-sm-2" type="text" placeholder="Search for Teams">
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
	<div w-type="event-discovery" w-tmapikey="ZFMGvqAbAeLyfwAymqLmH9RWy5cod7wo" w-googleapikey="YOUR_GOOGLE_API_KEY" 
	     w-keyword="MLB" 
	     w-theme="grid" 
	     w-colorscheme="dark" 
	     w-width="100%" w-height="550" w-size="25" w-border="2" w-borderradius="4" w-radius="25" 
	     w-period="week" 
	     w-layout="fullwidth" 
	     w-attractionid="" 
	     w-promoterid="" 
	     w-venueid="" 
	     w-affiliateid="" 
	     w-segmentid="" 
	     w-proportion="custom" 
	     w-titlelink="off" 
	     w-sorting="groupByName" 
	     w-id="id_mv63s" 
	     w-source="" 
	     w-branding="Ticketmaster" 
	     w-showfulleventsnames="true"
	     w-showloadmorebutton="true" 
	     w-countrycode="US" 
	     w-postalcode="07055" 
	     w-city="Los Angeles" 
	     w-latlong=""></div>
	<script src="https://ticketmaster-api-staging.github.io/products-and-docs/widgets/event-discovery/1.0.0/lib/main-widget.js"></script>
	<div w-type="calendar" w-tmapikey="ZFMGvqAbAeLyfwAymqLmH9RWy5cod7wo" w-googleapikey="YOUR_GOOGLE_API_KEY" 
	     w-keyword="NFL" 
	     w-theme="calendar" 
	     w-colorscheme="dark" 
	     w-width="298" 
	     w-height="400" 
	     w-size="25" 
	     w-border="1" 
	     w-borderradius="4" 
	     w-postalcode="" 
	     w-radius="25" 
	     w-countrycode="US" 
	     w-city="Los Angeles" 
	     w-period="week" 
	     w-periodweek="week" 
	     w-layout="vertical" 
	     w-classificationid="" 
	     w-attractionid="" 
	     w-promoterid="" 
	     w-venueid="" 
	     w-affiliateid="" 
	     w-segmentid="" 
	     w-proportion="standart" 
	     w-latlong=""></div>
	    <script src="https://ticketmaster-api-staging.github.io/products-and-docs/widgets/calendar/1.0.0/lib/main-widget.js"></script>
</div>
</body>
</html>
