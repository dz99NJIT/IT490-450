<?php
    //required files
    require_once("functions.php");

    //sends message and username to database
    //should return wether message was entered successfully or not
    echo sendMessage($_GET["username"],$_GET["message"]);

    //test using sendMessage.php?username=something&message=somethingeelse
    $username=$_GET["username"];
    $message=$_GET["message"];
?>
