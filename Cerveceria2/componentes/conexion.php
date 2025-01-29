<?php
     //abrimos bbdd

        session_start();

     $conn = mysqli_connect('localhost:3308','root','','cerveceria');
     
     // Check connection
     if (mysqli_connect_errno()) {
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
         exit();
     }

?>