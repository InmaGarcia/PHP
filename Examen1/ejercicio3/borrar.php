<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar Usuario</title>
    <link rel="stylesheet" href="../ejercicio3/css/estilos.css" />
</head>
<body>
    <h1>Borrar Uruario</h1>
    <form method="POST" action="borrar.php">
            <label>Dni:</label>
            <input type="text" name="dni">

            <input type="submit" value="Borrar Usuario" name="btnB">
            
    </form>
    <A HREF='javascript:history.back()'>Volver</A> </P>
    <?php
 
    //abrimos bbdd
    $conn = mysqli_connect("localhost","root","","usuarios");
    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    if (isset($_POST['btnB'])) {//si le damos al botón de borrar
        $dni = $_POST['dni'];
        $sql = "DELETE FROM usuarios WHERE DNI = '$dni'";

        if (mysqli_query($conn, $sql) && !empty($dni)) {
            echo "<p>Usuario eliminado con éxito.<p>";
            exit();
        } else {
            echo "<p>Error al eliminar el usuario " . mysqli_error($conn)."</p>";
        }
     }

    mysqli_close($conn);
    ?>
</body>
</html>