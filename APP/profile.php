<?php
session_start();
require_once('functions.php');
	loggedCheck();
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
					<li class="nav-item active">
						<a class="nav-link" href="favorites.php">Favorites</a>
					</li>
				</ul>
				<ul class="navbar-nav ml-auto">
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
			<h1>Edit Your Profile Here</h1>
			<?php $uname = $_SESSION["uname"]; echo "<h2>$uname</h2>"; ?>
			<br>
			<div class="row">
				<div class="col">
					<h4>This is your current profile info</h4>	
				</div>
				<div class="col">
					<h4>Fill in boxes of info you'd like to update</h4>
					<form action = "cases.php" method="POST">
						<input type="hidden" id="type" name="type" value="editProfile">
				  		<label for Fullname>Full Name:</label><br>
				  		<input type="text" id="Fullname" name="Fullname"><br><br>
							<label for email>Email:</label><br>
				  		<input type="email" id="email" name="email"><br><br>
						<input type="hidden" id="uname" name="uname" value="<?php $uname=$_SESSION["uname"];echo "$uname";?>">
				  		<label for pw>Password:</label><br>
				  		<input type="password" id="pw" name="pw"><br><br>
							<label for confirmPw>Confirm password:</label><br>
				  		<input type="password" id="confirmPw" name="confirmPw"><br><br>
							<input type="submit" class="btn btn-dark" value="Submit"><br><br><br>
					</form>	
				</div>
			</div>
		</div>
</body>
</html>
