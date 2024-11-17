<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="../ejercicio3/css/estilos.css" />
</head>
<body>
    <h1>Lista de Usuarios</h1>
    <?php
     //abrimos bbdd
     $conn = mysqli_connect("localhost","root","","usuarios");
     // Check connection
     if (mysqli_connect_errno()) {
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
         exit();
     }
     
     $sql = "SELECT Usuario FROM usuarios";
     $datos = mysqli_query($conn, $sql);
     // Verificar si hay resultados
     if ($datos) {
        $lista = "<ul>";
        
        // Procesar los resultados
        while ($arrayDatos = mysqli_fetch_assoc($datos)) {
            $lista .= "<li>" . htmlspecialchars($arrayDatos['Usuario']) . "</li>";
        }
        
        $lista .= "</ul>";
        echo $lista;
        print ("<P> <A HREF='javascript:history.back()'>Volver</A> </P>\n");
    } else {
        echo "No se encontraron usuarios.";
    }
     mysqli_close($conn);
    ?>
</body>
</html>