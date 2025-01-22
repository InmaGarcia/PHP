<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="./css/estilos.css" />
</head>
<body>
<?php
    include("header.html");
?>
<h1>Catálogo de Cervezas</h1>
<?php

//abrimos bbdd
     $conn = mysqli_connect("localhost","root","","usuarios");
     // Check connection
     if (mysqli_connect_errno()) {
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
         exit();
     }
     
     $sql = "SELECT * FROM cervezas";
     $datos = mysqli_query($conn, $sql);
     // Verificar si hay resultados
     if ($datos) {
        $div = "<div>";
        
        // Procesar los resultados
        while ($arrayDatos = mysqli_fetch_assoc($datos)) {
            $div .= "<p>" . htmlspecialchars($arrayDatos['Usuario']) . "</p>";
        }
        
        $div .= "</div>";
        echo $lista;
        print ("<P> <A HREF='javascript:history.back()'>Volver</A> </P>\n");
    } else {
        echo "No se encontraron usuarios.";
    }
     mysqli_close($conn);
?>
<?php
    include("footer.html");
?>
</body>
</html>