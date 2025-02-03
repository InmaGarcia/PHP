<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <style>
        nav {
            background-color: #68492c;
            display: flex;
        }
        nav ul {
            display: flex;
            justify-content: space-around;
            align-items: center;
            list-style: none;
            width: 100%;
        }
        nav li {
            padding: 1em;
        }
        nav ul a {
            text-decoration: none;
            color: bisque;
        }
        .insertar {
            display: grid;
            grid-template-columns: 20% 50%;
            gap: 0.2em;
            justify-content: center;
        }
        .cerveza{
            padding-left: 50px;
            font-size: 1.5em;
        }
    </style>
</head>

<body>
    <!-- Navegador que le aparece solo a los administradores -->
    <nav>
        <ul>
            <li><a href="?accion=insertar">Insertar Cerveza</a></li>
            <li><a href="?accion=modificar">Modificar Cerveza</a></li>
            <li><a href="?accion=borrar">Borrar Cerveza</a></li>
        </ul>
    </nav>

    <?php
//cojemos la accion del admin
$accion = $_GET['accion'] ?? '';
error_reporting(0);

//si la accion es insertar
if ($accion === "insertar") {
    $error1 = $error2 = $error3 = $error4 = $error5 = $error6 = "";

    if (isset($_POST["btnS"])) {
      

        // Validaciones
        if (empty($_POST['denominacion'])) {
            $error1 = "<p style='color:red;'>¡Se requiere el nombre de la cerveza!</p>";
        }

        if (!isset($_POST['tipo'])) {
            $error2 = "<p style='color:red;'>¡Has de elegir un tipo de cerveza!</p>";
        }

        if (!isset($_POST['alergias'])) {
            $error3 = "<p style='color:red;'>¡Has de elegir al menos un alérgeno!</p>";
        }

        if (empty($_POST['caducidad'])) {
            $error4 = "<p style='color:red;'>¡Debe tener una fecha de consumo máxima!</p>";
        }

        if (!is_numeric($_POST['precio']) || $_POST['precio'] <= 0) {
            $error5 = "<p style='color:red;'>¡El precio debe ser un valor numérico válido!</p>";
        }

        if ($_FILES['imagen']['error'] == 4) {
            $error6 = "<p style='color:red;'>¡Debe subir una imagen!</p>";
        } else {
            $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
            $nombre_archivo = $_FILES['imagen']['name'];
            $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);

            if (!in_array(strtolower($extension), $extensiones_permitidas)) {
                $error6 .= "<p style='color:red;'>¡Solo se permiten imágenes JPG, JPEG, PNG o GIF!</p>";
            }
        }

        // Si no hay errores, redirigir a insertar.php con los datos
        if (empty($errores)) {
            move_uploaded_file($_FILES["imagen"]["tmp_name"], "uploads/" . $_FILES["imagen"]["name"]);
            $ruta_img = "uploads/" . $_FILES["imagen"]["name"];
            // echo "<script>window.location.replace('./funciones/insertar.php');</script>";
            echo "<style> fieldset{display:none;}</style>";
                        
            echo "<div class='cerveza'><h2>Estos son los datos introducidos:</h2><ul>";
                    
            print ("<li>Denominación del alimento: {$_POST['denominacion']}</li>");
            print ("<li>Marca del producto:{$_POST['marca']}</li>");
            print ("<li>Tipo de cerveza: {$_POST['tipo']}</li>");
            print ("<li>Formato: {$_POST['formato']}</li>");
            print ("<li>Tamaño: {$_POST['cantidad']}</li>");
            print ("<li>Alergenos: ".implode(" - ",$_POST['alergias'])."</li>");
            print ("<li>Fecha consumo: {$_POST['caducidad']}</li>");
            print ("<li>Precio: {$_POST['precio']}</li>");
            print ("<li>Foto: {$_FILES['imagen']['name']}</li>");
            print ("<li>Observaciones: {$_POST['Obs']}</li><ul></div>");           
            
            $imagen=$_FILES['imagen'];

            //subimos la imagen al temporal del servidor
            function subir_fichero($directorio_destino, $imagen){
                if (!isset($imagen)) {
                    echo "<p style='color:red;'>ERROR: No se recibió ninguna imagen.</p>";
                    return false;
                }
                if ($imagen['error'] !== 0) {
                    echo "<p style='color:red;'>ERROR en el archivo: Código de error " . $imagen['error'] . "</p>";
                    return false;
                }
            
                $tmp_name = $imagen['tmp_name'];
                $img_file = $imagen['name'];
                $img_type = $imagen['type'];
            
                // Validar tipo de archivo
                $formatos_permitidos = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!in_array($img_type, $formatos_permitidos)) {
                    echo "<p style='color:red;'>ERROR: Formato de archivo no permitido ($img_type).</p>";
                    return false;
                }
            
            
                // Intentar mover el archivo
                $ruta_destino = $directorio_destino . '/' . $img_file;
                if (move_uploaded_file($tmp_name, $ruta_destino)) {
                    echo "<p style='color:green;'>✅ Imagen guardada en: $ruta_destino</p>";
                    return true;
                } else {
                    echo "<p style='color:red;'>❌ ERROR: No se pudo mover el archivo.</p>";
                    return false;
                }
                }

                    $directorio_destino = "C:/xampp/htdocs/Servidor/Cerveceria2/uploads";
                    $subido= subir_fichero($directorio_destino,$_FILES['imagen']);
            
                    // Guardar valores para la base de datos
                    $denominacion = mysqli_real_escape_string($conn, $_POST['denominacion']);
                    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
                    $cantidad = mysqli_real_escape_string($conn, $_POST['cantidad']);
                    $marca = mysqli_real_escape_string($conn, $_POST['marca']);
                    $fecha = mysqli_real_escape_string($conn, $_POST['caducidad']);
                    $alergias = mysqli_real_escape_string($conn, implode(",", $_POST['alergias']));
                    $observaciones = mysqli_real_escape_string($conn, $_POST['Obs']);

                    // Insertar en la base de datos
                    $sql = "INSERT INTO productos (denominacion, tipo, cantidad, marca, fecha, alergias, foto, observaciones)
                            VALUES ('$denominacion', '$tipo', '$cantidad', '$marca', '$fecha', '$alergias', '$ruta_img', '$observaciones', '$formato')";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Cerveza subida')</script>;";
                    exit();
                } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
              ?> 
            <!--  <button onclick="document.location.reload()">Insertar otra Cerveza</button> este boton no me funciona-->
            <?php
            exit();
        }
    }
    ?>

    <fieldset>
        <legend>Insertar Nueva Cerveza:</legend>
        <form action="" method="POST" enctype="multipart/form-data" class="insertar">
            
            <?= $error1 ?>
            <label>Denominación Cerveza:</label>
            <input type="text" id="denominacion" name="denominacion" value="<?= $_POST['denominacion'] ?? '' ?>"/>

            <label>Marca:</label>
            <select name="marca">
                <option value="Heineken">Heineken</option>
                <option value="Mahou">Mahou</option>
                <option value="DAM">DAM</option>
                <option value="Estrella">Estrella Galicia</option>
                <option value="Alhambra">Alhambra</option>
                <option value="Cruzcampo">Cruzcampo</option>
                <option value="Artesana">Artesana</option>
            </select>

            
            <label>Tipo de Cerveza:</label>
            <div>
                <input type="radio" name="tipo" value="lager"/> LAGER
                <input type="radio" name="tipo" value="pale" /> PALE ALE
                <input type="radio" name="tipo" value="negra" /> CERVEZA NEGRA
                <input type="radio" name="tipo" value="abadia" /> ABADIA
                <input type="radio" name="tipo" value="rubia" /> RUBIA
            </div>

            <label>Formato:</label>
            <select name="formato">
                <option value="lata">Lata</option>
                <option value="botella">Botella</option>
                <option value="pack">Pack</option>
            </select>

            <label>Tamaño:</label>
            <!-- en la base de datos cantidad es integer, por eso lo cambio el valor a número -->
            <select name="cantidad">
                <option value="20">Botellín</option>
                <option value="33">Tercio</option>
                <option value="50">Media</option>
                <option value="100">Litrona</option>
            </select>


            <label>Alérgenos:</label>
            <div>
                <input type="checkbox" name="alergias[]" value="Gluten" /> Gluten
                <input type="checkbox" name="alergias[]" value="Huevo" /> Huevo
                <input type="checkbox" name="alergias[]" value="Cacahuete" /> Cacahuete
                <input type="checkbox" name="alergias[]" value="Soja" /> Soja
                <input type="checkbox" name="alergias[]" value="Lacteo" /> Lácteo
                <input type="checkbox" name="alergias[]" value="Sulfitos" /> Sulfitos
                <input type="checkbox" name="alergias[]" value="Sin" /> Sin alérgenos
            </div>

            
            <label>Fecha Consumo:</label>
            <input type="date" id="caducidad" name="caducidad" value="<?= $_POST['caducidad'] ?? '' ?>"/>

            
            <label>Foto:</label>
            <input type="file" name="imagen" id="imagen" accept="image/*"/>

            
            <label>Precio (€):</label>
            <input type="number" id="precio" name="precio" step="0.01" value="<?= $_POST['precio'] ?? '' ?>"/>

            <label>Observaciones:</label>
            <textarea name="Obs"><?= $_POST['Obs'] ?? '' ?></textarea>

            <input type="submit" value="Insertar Cerveza" id="btn-submit" name="btnS"/>
        </form>
    </fieldset>


<?php
} elseif ($accion === "modificar") {
   
    $sql = "SELECT * FROM productos";
    $datos = mysqli_query($conn, $sql);
    // Código para modificar cervezas...
} elseif ($accion === "borrar") {
   
    $sql = "SELECT * FROM productos";
    $datos = mysqli_query($conn, $sql);
    // Código para borrar cervezas...
} else {
    echo "<p>Seleccione una opción del menú.</p>";
}
?>

</body>
</html>