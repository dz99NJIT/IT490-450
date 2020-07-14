<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    echo update();
    function update(){
      require_once("connection.php");

        $query="SELECT * FROM chat";
        $result=mysqli_query($con,$query);
        $returnval="";
        while($row = mysqli_fetch_array($result)){
            $returnval.="<div class='chat'>";
            $returnval.= "<div>{$row[0]} </div>";
            $returnval.= "<div>{$row[1]} </div>";
            $returnval.= "</div>";
        }
        return $returnval;
    }
?>
