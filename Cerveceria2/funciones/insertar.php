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
   
   echo "<div class='nueva'><h2>Datos de la cerveza insertada:</h2>";
          
          print ("<p>Denominación del alimento: {$_POST['denominacion']}</p>");
          print ("<p>Marca del producto:{$_POST['marca']}</p>");
          print ("<p>Tipo de cerveza: {$_POST['tipo']}</p>");
          print ("<p>Formato: {$_POST['formato']}</p>");
          print ("<p>Tamaño: {$_POST['cantidad']}</p>");
          print ("<p>Alergenos: ".implode(" - ",$_POST['alergias'])."</p>");
          print ("<p>Fecha consumo: {$_POST['caducidad']}</p>");
          print ("<p>Precio: {$_POST['precio']}</p>");
          print ("<p>Foto: {$_POST['imagen']['name']}</p>");
          print ("<p>Observaciones: {$_POST['observaciones']}</p></div>");
   
        
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
            //Si llegamos aquí es que algo ha fallado
            return false;
        }

        $directorio_destino="C:\xampp\htdocs\Servidor\Cerveceria2\upload";
        $subido= subir_fichero($directorio_destino,$imagen);
        if(!$subido){
            echo "alert('No se puede guardar la imagen correctamente');";
        }else{
            $ruta_img = $directorio_destino."/".$imagen['name'];
                $sql = "INSERT INTO productos (denominacion,tipo,cantidad,marca,fecha,alergias,foto,observaciones)
                        VALUES ($_POST[denominacion],$_POST[tipo],$_POST[cantidad],$_POST[marca],$_POST[fecha],$_POST[alergias],'$ruta_img',$_POST[observaciones])";
                if (mysqli_query($conn, $sql)) {
                      echo "alert('Cerveza subida');";
                      exit();
                } else {
                      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
        }
   ?>
   <button onclick="history.back()">Insertar otra Cerveza</button>
    
</body>
</html>