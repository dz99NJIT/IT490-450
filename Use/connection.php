<?php

    //Connects to database
    function dbConnect(){
        
      $mydb = new mysqli('127.0.0.1','it490admin','LetM3in!','SportWatch');
      
      if ($mydb->errno != 0)
      {
      	echo "failed to connect to database: ". $mydb->error . PHP_EOL;
      	exit(0);
      }
        
      echo "Connection established to database".PHP_EOL;
      return $mydb;
}

?>
