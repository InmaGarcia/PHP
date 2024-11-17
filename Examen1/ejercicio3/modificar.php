<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar</title>
    <link rel="stylesheet" href="../ejercicio3/css/estilos.css" />
</head>
<body>
    <h1>Modificar Usuario</h1>

    <form enctype="multipart/form-data" method="POST" action="modificar.php">
        <label>Dni:</label>
        <input type="text" name="dni">
 
        <label>Nombre:</label>
        <input type="text" name="nombre">
 
        <label>Apellidos:</label>
        <input type="text" name="apellidos">
 
        <label>Añadir imagen:</label>
        <input type="file" name="imagen" id="imagen" />
 
        <label>Usuario:</label>
        <input type="text" name="usuario">
 
        <label>Contraseña:</label>
        <input type="password" name="password">
 
        <input type="submit" value="Actualizar" name="btnA">
    </form>
    <P> <A HREF='javascript:history.back()'>Volver</A> </P>
    <?php
        // Abrir conexión
        $conn = mysqli_connect("localhost", "root", "", "usuarios");
        if (mysqli_connect_errno()) {
            echo "Error al conectar con la base de datos: " . mysqli_connect_error();
            exit();
        }

        if (isset($_POST['btnA'])) { // Si le damos al botón actualizar
            $dni = $_POST['dni'];

            // Cojemos el usuario que ya existe en la bbdd
            $sql = "SELECT * FROM usuarios WHERE DNI = '$dni'";
            $resultado = mysqli_query($conn, $sql);
            $usuarioBBDD = mysqli_fetch_assoc($resultado);

            if ($usuarioBBDD) { // Si se encontró el usuario
                // Cojemos los valores del from y si esta vacio dejamos los de bbdd
                $nombre = isset($_POST['nombre']) && !empty($_POST['nombre']) 
                    ? mysqli_real_escape_string($conn, $_POST['nombre']) 
                    : $usuarioBBDD['Nombre'];

                $apellidos = isset($_POST['apellidos']) && !empty($_POST['apellidos']) 
                    ? mysqli_real_escape_string($conn, $_POST['apellidos']) 
                    : $usuarioBBDD['Apellidos'];

                $usuario = isset($_POST['usuario']) && !empty($_POST['usuario']) 
                    ? mysqli_real_escape_string($conn, $_POST['usuario']) 
                    : $usuarioBBDD['Usuario'];

                $password = isset($_POST['password']) && !empty($_POST['password']) 
                    ? password_hash($_POST['password'], PASSWORD_DEFAULT) 
                    : $usuarioBBDD['Contraseña'];

                // Manejamos la imagen
                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                    $directorio_destino = "uploads";
                    $imagen = $_FILES['imagen']['name'];
                    $ruta_imagen = $directorio_destino . '/' . basename($imagen);
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
                        $foto = $ruta_imagen;
                    } else {
                        $foto = $usuarioBBDD['Foto']; // Si la carga falla, mantenemos la que teniamos
                    }
                } else {
                    $foto = $usuarioBBDD['Foto']; //aqui igual por si algo falla
                }

                // Actualizar los datos en bbdd
                $sqlUpdate = "UPDATE usuarios 
                            SET Nombre = '$nombre', 
                                Apellidos = '$apellidos', 
                                Foto = '$foto', 
                                Usuario = '$usuario', 
                                Contraseña = '$password'
                            WHERE DNI = '$dni'";

                if (mysqli_query($conn, $sqlUpdate)) {
                    echo "Usuario actualizado correctamente.";
                } else {
                    echo "Error al actualizar el usuario: " . mysqli_error($conn);
                }
            } else {
                echo "Usuario no encontrado.";
            }
        }

        mysqli_close($conn);
    ?>
</body>
</html>