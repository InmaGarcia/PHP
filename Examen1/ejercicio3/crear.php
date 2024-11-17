<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario Nuevo</title>
    <link rel="stylesheet" href="../ejercicio3/css/estilos.css" />
</head>
<body>
    <h1>Nuevo Usuario</h1>
    <form enctype="multipart/form-data" method="POST" action="crear.php">
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
 
        <input type="submit" value="Añadir" name="btnA">
    </form>
    <P> <A HREF='javascript:history.back()'>Volver</A> </P>;
 
    <?php
 
    //abrimos bbdd
    $conn = mysqli_connect("localhost","root","","usuarios");
    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
   
        if (isset($_POST['btnA'])) {//si le damos al botón de añadir
            //cojemos los valores de todos nuestros campos
            $dni = $_POST['dni'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $imagen = $_FILES['imagen'];
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];
 
            //comprobar que el nombre sigue un patron
            function isNombre($text){
                $pattern = '/[a-zA-Z\sñáéíóúÁÉÍÓÚ]/';
                return preg_match($pattern, $text);
            }
 
            //comprobar patron del dni
            function is_valid_dni($dni){
                $letter = substr($dni, -1);
                $numbers = substr($dni, 0, -1);
             
                if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numbers%23, 1) == $letter && strlen($letter) == 1 && strlen ($numbers) == 8 ){
                  return true;
                }
                return false;
              }
            
              //comprobamos si existe en la bbdd
            function existe($usuario){
                global $conn;
                $sql = "SELECT Usuario FROM usuarios WHERE Usuario = '$usuario'";
                $existe = mysqli_query($conn, $sql);

                return mysqli_num_rows($existe) > 0;
            }
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
             //Introducimos los datos si los valores son correctos
             //si no son correcto sacame los errores
             $correcto = false;
             $error="<ul>";
            if(!empty($dni) && is_valid_dni($dni)){$correcto = true;}
                else{
                    $error .= "<li>Dni NO válido</li>";
                    $correcto = false;}
            if(!empty($nombre) && isNombre($nombre)){$correcto = true;}
                else{
                    $error .= "<li>El nombre no es válidos</li>";
                    $correcto = false;}
            if(!empty($apellidos) && isNombre($apellidos)){$correcto = true;}
                else{
                    $error .= "<li>Los apellidos no son válidos</li>";
                    $correcto = false;}
            if(!empty($imagen)){
                $directorio_destino="C:\xampp\htdocs\Servidor\Examen1\ejercicio3\upload";
                $subido= subir_fichero($directorio_destino,$imagen);
                if(!$subido){
                    $correcto = false;
                }
            }
                else{
                    $error .= "<li>Imagen no válida</li>";
                    $correcto = false;}
            if(!empty($usuario) && !existe($usuario) ){$correcto = true;}
                else{
                    $error .= "<li>Usuario no válido o ya existe</li>";
                    $correcto = false;}
            if(!empty($password) && strlen($password) > 6 && strlen($password) < 8){$correcto = true;}
                else{
                    $error .= "<li>Contraseña NO válida</li>";
                    $correcto = false;}
 
            if($correcto){//si es correcto insertalo en bbdd
                $ruta_img = $directorio_destino."/".$imagen['name'];
                $sql = "INSERT INTO usuarios (DNI, Nombre, Apellidos, Foto, Usuario, Contraseña)
                        VALUES ('$dni', '$nombre', '$apellidos','$ruta_img' , '$usuario', '$password')";
                if (mysqli_query($conn, $sql)) {
                      echo "Creado nuevo usuario";
                      exit();
                } else {
                      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }else{
                $error .= "</ul>";
                echo $error;
            }
        }
        
        mysqli_close($conn);
    ?>
</body>
</html>