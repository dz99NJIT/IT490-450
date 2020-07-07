<?php
	include("function.php");	
	$teamReturn[] = search($_GET["searchText"]);
	print_r($teamReturn);
?>
