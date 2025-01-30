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

$accion = $_GET['accion'] ?? '';
error_reporting(0);

if ($accion === "insertar") {
    $error1 = $error2 = $error3 = $error4 = $error5 = $error6 = "";

    if (isset($_POST["btnS"])) {
        $errores = [];
        $_SESSION['cerveza'] = $_POST; // Guardamos los datos en sesión para usarlos en insertar.php

        // Validaciones
        if (empty($_POST['denominacion'])) {
            $error1 = "<p style='color:red;'>¡Se requiere el nombre de la cerveza!</p>";
            $errores[] = $error1;
        }

        if (!isset($_POST['tipo'])) {
            $error2 = "<p style='color:red;'>¡Has de elegir un tipo de cerveza!</p>";
            $errores[] = $error2;
        }

        if (!isset($_POST['alergias'])) {
            $error3 = "<p style='color:red;'>¡Has de elegir al menos un alérgeno!</p>";
            $errores[] = $error3;
        }

        if (empty($_POST['caducidad'])) {
            $error4 = "<p style='color:red;'>¡Debe tener una fecha de consumo máxima!</p>";
            $errores[] = $error4;
        }

        if (!is_numeric($_POST['precio']) || $_POST['precio'] <= 0) {
            $error5 = "<p style='color:red;'>¡El precio debe ser un valor numérico válido!</p>";
            $errores[] = $error5;
        }

        if ($_FILES['imagen']['error'] == 4) {
            $error6 = "<p style='color:red;'>¡Debe subir una imagen!</p>";
            $errores[] = $error6;
        } else {
            $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
            $nombre_archivo = $_FILES['imagen']['name'];
            $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);

            if (!in_array(strtolower($extension), $extensiones_permitidas)) {
                $error6 .= "<p style='color:red;'>¡Solo se permiten imágenes JPG, JPEG, PNG o GIF!</p>";
                $errores[] = $error6;
            }
        }

        // Si no hay errores, redirigir a insertar.php con los datos
        if (empty($errores)) {
            move_uploaded_file($_FILES["imagen"]["tmp_name"], "uploads/" . $_FILES["imagen"]["name"]);
            $_SESSION['imagen'] = "uploads/" . $_FILES["imagen"]["name"];
            header("Location: /Servidor/Cerveceria2/funciones/insertar.php");
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
            <select name="cantidad">
                <option value="botellin">Botellín</option>
                <option value="tercio">Tercio</option>
                <option value="media">Media</option>
                <option value="litrona">Litrona</option>
                <option value="pack">Pack</option>
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
    $conn = mysqli_connect("localhost", "usuario", "contraseña", "base_de_datos");
    $sql = "SELECT * FROM productos";
    $datos = mysqli_query($conn, $sql);
    // Código para modificar cervezas...
} elseif ($accion === "borrar") {
    $conn = mysqli_connect("localhost", "usuario", "contraseña", "base_de_datos");
    $sql = "SELECT * FROM productos";
    $datos = mysqli_query($conn, $sql);
    // Código para borrar cervezas...
} else {
    echo "<p>Seleccione una opción del menú.</p>";
}
?>

</body>
</html>