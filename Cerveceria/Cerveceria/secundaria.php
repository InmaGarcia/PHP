<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cervecería Online</title>
</head>
<body>
    <?php
    //
    error_reporting(0); 
  
    $tipo = $_REQUEST['Tipo'];
    $denominacion = $_REQUEST['Deno'];
    $envase = $_REQUEST['envase'];
    $cantidad = $_REQUEST['Cantidad'];
    $marca = $_REQUEST['marca'];
    $advert = $_REQUEST['advert'];
    $caducidad = $_REQUEST['caducidad'];
    $alergias = $_REQUEST['alergias'];
    $observacion = $_REQUEST['Obs'];
    // $fichero = $_REQUEST['fichero'];


        $errores = "";
        if (trim($marca) == "")
           $errores = $errores . "   <LI>Se requiere Marca\n";
        if (trim($advert) == "")
           $errores = $errores . "   <LI>Es Obligatoriola advertencia sobre el abuso del consumo de alcohol\n";
        if (!$caducidad)
          $errores = $errores . "   <LI>No ha introducido fecha\n";
        if (empty($alergias))
          $errores = $errores . "    <LI>Es obligatorio incluir alergenos\n";
  
        
  // Mostrar errores encontrados
        if ($errores != "")
        {
           print ("<P>No se ha podido realizar la inserci&oacute;n debido a los siguientes errores:</P>\n");
           print ("<UL>");
           print ($errores);
           print ("</UL>");
           print ("<P>[ <A HREF='javascript:history.back()'>Volver</A> ]</P>\n");  
        }
        else{
          print ("<p>Tipo de cerveza: </p>".$tipo);
          print ("<p>Denominación del alimento: </p>".$denominacion);
          print ("<p>Tipo envase: </p>".$envase);
          print ("<p>Cantidad neta: </p>".$cantidad);
          print ("<p>Marca del producto: </p>".$marca);
          print ("<p>Advertencia sobre el abuso en el consumo de alcohol: </p>".$advert);
          print ("<p>Fecha de consumo preferente: </p>".$caducidad);
          print ("<p>Indicar sustancias que pueden causar alergias: </p>".implode(" - ",$alergias));
          print ("<p>Observaciones: </p>".$observacion);
        }

      //   //Recogida y errores fichero
      //   $msgError = [
      //     0 => "No hay error, el fichero se subió con éxito",
      //     1 => "El tamaño del fichero supera la directiva upload_max_filesize en php.ini",
      //     2 => "El tamaño del fichero supera la directiva MAX_FILE_SIZE especificada en el formulario HTML",
      //     3 => "El fichero fue parcialmente subido",
      //     4 => "No se ha subido un fichero",
      //     6 => "No existe un directorio temporal",
      //     7 => "Fallo al escribir el fichero al disco",
      //     8 => "La subida del fichero fue detenida por la extensión"
      // ];
      
      // if ($_FILES["fichero"]["error"] > 0) {
      //   print "Error: ".$msgError[$_FILES["fichero"]["error"]]."<br />";
      // } else {
      //     print "Nombre original: ".$_FILES["fichero"]["name"]."<br />";
      //     print "Tipo: ".($_FILES["fichero"]["type"])."<br />";
      //     print "Tamaño: ".ceil($_FILES["fichero"]["size"] / 1024)." Kb<br />";
      //     print "Nombre temporal: ".($_FILES["fichero"]["tmp_name"])."<br />";
      
      //     if (file_exists("upload/".$_FILES["fichero"]["name"])) {
      //       print $_FILES["fichero"]["name"]." ya existe";
      //     } else {
      //         move_uploaded_file($_FILES["fichero"]["tmp_name"], "upload/".$_FILES["fichero"]["name"]);
      //         print "Almacenado en: "."upload/" .$_FILES["fichero"]["name"];
              
      //     }
      // }

      //Al pulsar subir imagen
      if (isset($_POST['subirImagen'])) {
        if (isset($_FILES['imagen'])) {
          $imagen = $_FILES['imagen'];
          $extensiones_permitidas = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];
          $tamano_maximo = 2 * 1024 * 1024; // 2 MB
          $msgError = [
              UPLOAD_ERR_OK => "No hay error, el archivo se subió correctamente.",
              UPLOAD_ERR_INI_SIZE => "El archivo excede el tamaño permitido por la configuración del servidor.",
              UPLOAD_ERR_FORM_SIZE => "El archivo excede el tamaño máximo permitido en el formulario.",
              UPLOAD_ERR_PARTIAL => "El archivo fue subido parcialmente.",
              UPLOAD_ERR_NO_FILE => "No se ha subido ningún archivo.",
              UPLOAD_ERR_NO_TMP_DIR => "Falta un directorio temporal en el servidor.",
              UPLOAD_ERR_CANT_WRITE => "Error al escribir el archivo en el disco.",
              UPLOAD_ERR_EXTENSION => "La subida del archivo fue detenida por una extensión PHP."
          ];
  
          // Verifica errores en la carga del archivo
          if ($imagen['error'] !== UPLOAD_ERR_OK) {
              echo "Error al subir la imagen: " . $msgError[$imagen['error']];
          } 
          // Verifica tipo y tamaño del archivo
          elseif (!in_array($imagen['type'], $extensiones_permitidas) || $imagen['size'] > $tamano_maximo) {
              echo "<b>Error. La extensión o el tamaño del archivo no es válido.</b>";
          } 
          // Mueve el archivo subido al directorio especificado
          else {
            if (!is_dir('upload')) {
                mkdir('upload', 0777, true); // Crea la carpeta si no existe
            }
              $destino = "upload/" . basename($imagen['name']);
              if (move_uploaded_file($imagen['tmp_name'], $destino)) {
                  echo '<p><img src="' . $destino . '" alt="Imagen subida"></p>';
                  echo "<p>Nombre original: " . htmlspecialchars($imagen['name']) . "</p>";
                  echo "<p>Tipo: " . htmlspecialchars($imagen['type']) . "</p>";
                  echo "<p>Tamaño: " . round($imagen['size'] / 1024, 2) . " KB</p>";
                  echo "<p>Guardado en: " . htmlspecialchars($destino) . "</p>";
              } else {
                  echo "Error al mover la imagen al directorio destino.";
              }
          }
      } else {
          echo "Error: no se ha seleccionado ninguna imagen.";
      }
  }


    ?>
    
</body>
</html>