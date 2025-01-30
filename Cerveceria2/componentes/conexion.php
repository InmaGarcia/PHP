<?php
     //abrimos bbdd
        session_id();
        session_start();

     $conn = mysqli_connect('localhost:3306','root','','cerveceria');
     
     // Check connection
     if (mysqli_connect_errno()) {
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
         exit();
     }

?>