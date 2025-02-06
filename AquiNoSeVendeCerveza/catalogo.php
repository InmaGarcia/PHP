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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/estilos.css" />
</head>
<body>
<?php
    include("./componentes/header.html");
    // error_reporting(0);
    if($_SESSION['perfil']==='admin'){
        include("admin.php");
    }
?>
<main>
<h1>Catálogo de Cervezas</h1>
<?php
     
     $sql = "SELECT * FROM productos";
     $arrayDatos  = mysqli_query($conn, $sql);
     $nr = mysqli_num_rows($arrayDatos); 
     $datos= mysqli_fetch_array($arrayDatos);
     // Verificar si hay resultados
     
     if ($nr>0) {
        echo "<div class='galeria'>";//abro la galeria de imagenes
        
         // Recorrer los resultados
         while ($datos = mysqli_fetch_array($arrayDatos)) {
            echo "<div class='card m-2' style='width: 18rem;'>";
            echo "<img src='".htmlspecialchars($datos['foto'])."' class='card-img-top' alt='Cerveza'>";
            echo "<div class='card-body'>";
            echo "<h3>".htmlspecialchars($datos['marca'])." - ".htmlspecialchars($datos['tipo'])."</h3>";
            echo "<p>".htmlspecialchars($datos['denominacion'])."</p>";
            echo "<p>Formato: ".htmlspecialchars($datos['formato'])."</p>";
            echo "<p>Tamaño: ".htmlspecialchars($datos['cantidad'])."</p>";
            echo '<a href="#" class="card-link">Más info</a>';
            echo '<a href="#" class="card-link">Comprar</a>';
            echo "</div></div>";
        }

        echo "</div>"; //cierro la galeria una vez recorrido los resultados de la cnsulta
    } else {
        echo "No se encontraron cervezas.";
    }
    
     mysqli_close($conn);//cierro coonexion
?>
</main>
<?php
    include("./componentes/footer.html");

?>
</body>
</html>