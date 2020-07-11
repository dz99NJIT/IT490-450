<?php
      require 'connection.php';
      $clientname=$_POST["clientname"];
      $date=$_POST["date"];
      $realtorname=$_POST["realtorname"];

      $query = "INSERT INTO Appointment VALUES ('$realtorname','$clientname','$date')";
      $result=mysqli_query($con,$query);

      $query = "SELECT * FROM Realtor INNER JOIN Appointment ON Realtor.Name=Appointment.Realtor WHERE Realtor ='" . $realtorname . "'";
      $result=mysqli_query($con,$query);
      echo "<h1>After insert</h1>";
      echo "<table border=1px style='width:100%'>";
      echo "<tr>";
      echo "<th>Realtor's Name</th>";
      echo "<th>Realtor's Password</th>";
      echo "<th>Realtor's ID</th>";
      echo "<th>Realtor's Email</th>";
      echo "<th>Client</th>";
      echo "<th>Appointment</th>";
      echo "</tr>";
      while($row = mysqli_fetch_array($result)){
          echo "<tr>";
          echo "<td>" . $row[0] . "</td>";
          echo "<td>" . $row[1] . "</td>";
          echo "<td>" . $row[2] . "</td>";
          echo "<td>" . $row[3] . "</td>";
          echo "<td>" . $row[5] . "</td>";
          echo "<td>" . $row[6] . "</td>";
          echo "</tr>";
      }
      echo "</table>";
?>
