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
  </ul>
  <ul class="navbar-nav ml-auto">
	<li class="nav-item active">
      <a class="nav-link" href="logout.php">Logout</a>
    </li>
  </ul>
</nav>
<br><br><br>

<div class="container-fluid">
	 <?php $uname = $_SESSION["uname"]; echo "<h1>Welcome $uname</h1>"; ?>
</div>
<div id="test"></div>

</body>
</html>
