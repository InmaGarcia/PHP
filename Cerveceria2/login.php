<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    include("header.html");
    ?>
    <main>
        <fieldset class="contenedor">
            <legend>Iniciar Sesión</legend>
            <form class="registro">
                <label>Email de usuario</label>
                <input type="text" name="email">
                <label>Contraseña</label>
                <input type="password" name="password">
                <input type="submit" value="Acceder" name="btnA">
            </form>
        </fieldset>
    </main>
    <?php
        //abrimos bbdd
    $conn = mysqli_connect("localhost","root","","usuario");
    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }
    if (isset($_POST['btnA'])) {//si le damos al botón de acceder
        //cojemos los valores de todos nuestros campos
        $email = $_POST['email'];
        $password = $_POST['password'];

         //comprobamos si existe en la bbdd
         function existe($email){
            global $conn;
            $sql = "SELECT correo FROM usuarios WHERE correo = '$email'";
            $existe = mysqli_query($conn, $sql);

            return mysqli_num_rows($existe) > 0;
        }

        $correcto = false;
        if(!empty($email) && existe($email) ){
            $correcto = true;
        }else{
            $error .= "Usuario no válido";
            $correcto = false;
        }
        if(!empty($password) && strlen($password) > 6 && strlen($password) < 8){
            $correcto = true;
        }else{
            $error .= "<li>Contraseña NO válida</li>";
            $correcto = false;
        }

        if($correcto){//si es correcto insertalo en bbdd
            //ver que perfil es y segun eso vamos a un sitio u a otro
            } else {
                  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }else{
            $error .= "</ul>";
            echo $error;
        }
    
    ?>
    <?php
    include("footer.html");
    ?>
    
</body>
</html>