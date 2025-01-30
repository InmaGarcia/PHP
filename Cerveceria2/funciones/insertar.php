<?php
    include('../componentes/conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: Insertar</title>
</head>
<body>
    <?php

    if (!isset($_SESSION['cerveza']) || empty($_SESSION['cerveza'])) {
        echo "<script>alert('No se pasaron los datos de la cerveza correctamente');</script>";
        exit();
    }
    $cerveza = $_SESSION['cerveza'];
   $imagen = $_SESSION['imagen'] ?? '';
   
   echo "<h2>Datos de la cerveza a insertar:</h2>";
          
          print ("<p>Denominación del alimento: {$cerveza['denominacion']}</p>");
          print ("<p>Marca del producto:{$cerveza['marca']}</p>");
          print ("<p>Tipo de cerveza: {$cerveza['tipo']}</p>");
          print ("<p>Formato: {$cerveza['formato']}</p>");
          print ("<p>Tamaño: {$cerveza['cantidad']}</p>");
          print ("<p>Alergenos: ".implode(" - ",$cerveza['alergias'])."</p>");
          print ("<p>Fecha consumo: {$cerveza['caducidad']}</p>");
          print ("<p>Precio: {$cerveza['precio']}</p>");
          print ("<p>Foto: {$imagen['nombre']}</p>");
          print ("<p>Observaciones: {$cerveza['observaciones']}</p>");
   
        
        //subimos la imagen al temporal del servidor
        function subir_fichero($directorio_destino, $imagen){
            $tmp_name = $imagen['tmp_name'];
            //si hemos enviado un directorio que existe realmente y hemos subido el archivo    
            if (is_dir($directorio_destino) && is_uploaded_file($tmp_name)){
                $img_file = $imagen['name'];
                $img_type = $imagen['type'];
                echo 1;
                // Si se trata de una imagen   
                if (((strpos($img_type, "gif") || strpos($img_type, "jpeg") ||
                    strpos($img_type, "jpg")) || strpos($img_type, "png"))){
                    //¿Tenemos permisos para subir la imágen?
                    echo 2;
                    if (move_uploaded_file($tmp_name, $directorio_destino . '/' . $img_file)){
                        return true;
                    }
                }
            }
            //Si llegamos hasta aquí es que algo ha fallado
            return false;
        }

        $directorio_destino="C:\xampp\htdocs\Servidor\Cerveceria2\upload";
        $subido= subir_fichero($directorio_destino,$imagen);
        if(!$subido){
            echo "alert('No se puede guardar la imagen correctamente');";
        }else{
            $ruta_img = $directorio_destino."/".$imagen['name'];
                $sql = "INSERT INTO productos (denominacion,tipo,cantidad,marca,fecha,alergias,foto,observaciones)
                        VALUES ($cerveza[denominacion],$cerveza[tipo],$cerveza[cantidad],$cerveza[marca],$cerveza[fecha],$cerveza[alergias],'$ruta_img',$cerveza[observaciones])";
                if (mysqli_query($conn, $sql)) {
                      echo "alert('Cerveza subida');";
                      exit();
                } else {
                      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
        }
        $_SESSION['cerveza']="";
        $_SESSION['imagen']="";
   ?>
   <button onclick="history.back()">Volver</button>
    
</body>
</html>