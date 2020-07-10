<?php
	include("functions.php");
	$teamReturn = search($_GET["searchText"]);
	echo $teamReturn;
?>
