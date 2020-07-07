<?php
	include("functions.php");	
	$teamReturn[] = search($_GET["searchText"]);
	print_r($teamReturn);
?>
