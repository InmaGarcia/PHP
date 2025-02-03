<?php
    include('./componentes/conexion.php');
?>
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
    include("./componentes/header.html");
    error_reporting(0);
    if($_SESSION['perfil']==='admin'){
        include("adminHeader.php");
    }else{
?>
<main>
<h1>Catálogo de Cervezas</h1>
<?php
     
     $sql = "SELECT * FROM productos";
     $arrayDatos  = mysqli_query($conn, $sql);
     // Verificar si hay resultados
     $galeria = "<div class='galeria'>";
     if ($datos) {
        $producto="<div class='card'>";
        
        // Procesar los resultados
        while ($datos = mysqli_fetch_assoc($arrayDatos )) {
            var_dump($datos );
            $producto .= "<img src='".htmlspecialchars($datos['foto'])."'/>";
            $producto .= "<h3>".htmlspecialchars($datos['marca'])." - ".htmlspecialchars($datos['tipo'])."</h3>";
            $producto .= "<p>".htmlspecialchars($datos['denominacion'])."</p>";
            $producto .= "<p>Formato: ".htmlspecialchars($datos['formato'])."</p>";
            $producto .= "<p>Tamaño: ".htmlspecialchars($datos['denominacion'])."</p>";
        }
        
        $producto.="</div>";
        $galeria .= $producto;
        echo $lista;
    } else {
        echo "No se encontraron cervezas.";
    }
    $galeria .= "</div>";
     mysqli_close($conn);
?>
</main>
<?php
    }
    include("./componentes/footer.html");

?>
</body>
</html>