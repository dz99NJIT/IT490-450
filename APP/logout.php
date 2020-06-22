<?php   
session_start();
session_destroy();
echo "User Logged out Succesfully";
header("refresh:2; url=index.html");
?>
