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
    <link rel="stylesheet" href="./css/estiloLogin.css" />
    <script src="./js/codigo.js"></script>  
</head>
<body>
    <?php
    include("./componentes/header.html");
    ?>
    <main>
        <div class="container">
            <div class="container-form">
                <form action="login.php" method="POST"class="sign-in">
                    <h2>Iniciar sesion</h2>
                    <span>Ingrese su correo y contraseña</span>
                    <div class="container-input">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="text" placeholder="Email" name="email">
                    </div>
                    <div class="container-input">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" placeholder="Password" name="password">
                    </div>
                    <a href="#">¿Olvidaste tu contraseña?</a>
                    <button class="btn" name="btn-inicio">Iniciar sesión</button>
                </form>
            </div>
            <div class="container-form">
                <form action="registro.php" method="POST" class="sign-up">
                    <h2>Registrarse</h2>
                    <span>Use su email para el registro</span>
                    <div class="container-input">
                    <i class="fa-regular fa-user"></i>
                        <input type="text" placeholder="Email" name="email">
                    </div>
                    <span>Introduzca su edad</span>
                    <div class="container-input">
                        <i class="fa-regular fa-calendar"></i>
                        <input type="number" placeholder="edad" name="edad">
                    </div>
                    <div class="container-input">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" placeholder="Password" name="password">
                    </div>
                    
                    <button class="btn" name="btn-registro">Registrarse</button>
                </form>
            </div>
            <div class="container-welcome">
                <div class="welcome-sign-up welcome">
                    <h3>¡Bienvenido!</h3>
                    <p>Registre sus datos personales poder acceder a todas nuestras opciones de compra</p>
                    <button class="btn" id="btn-sign-up">Registrarse</button>
                </div>
                <div class="welcome-sign-in welcome">
                    <h3>¡Hola!</h3>
                    <p>Ingrese sus datos personales para comprar</p>
                    <button class="btn" id="btn-sign-in">Iniciar Sesion</button>
                </div>
            </div>
        </div>
        <?php

            include('./componentes/conexion.php');

            $email = $_POST["email"];
            $pass 	= $_POST["password"];
            $edad 	= $_POST["edad"];

            //Para iniciar sesión
            if(isset($_POST["btn-inicio"]))
            {

            $queryusuario = mysqli_query($conn,"SELECT * FROM usuarios WHERE correo = '$email'");
            $nr 		= mysqli_num_rows($queryusuario); 
            $mostrar	= mysqli_fetch_array($queryusuario); 
                
            if (($nr == 1) && (password_verify($pass,$mostrar['password'])) )
                { 
                    session_id();
                    session_start();
                    $_SESSION['email']=$email;
                    $_SESSION['perfil']=$mostrar['perfil'];
                    header("Location: index.php");
                }
            else
                {
                echo "<script> alert('Usuario o contraseña incorrecto.'); </script>";
                }
            }

            //Para registrar
            if(isset($_POST["btn-registro"]))
            {

            $queryusuario 	= mysqli_query($conn,"SELECT * FROM usuarios WHERE correo = '$email'");
            $nr 			= mysqli_num_rows($queryusuario); 

            if ($nr == 0)
            {

                $pass_fuerte = password_hash($pass, PASSWORD_BCRYPT);
                $queryregistrar = "INSERT INTO usuarios(correo, password, edad, perfil) values ('$email','$pass_fuerte','$edad','usuario')";
                

            if(mysqli_query($conn,$queryregistrar))
            {
                echo "<script> alert('Inicia Sesión con el usuario: $email');window.location= 'InicioRegistro.php' </script>";
            }
            else 
            {
                echo "Error: " .$queryregistrar."<br>".mysql_error($conn);
            }

            }else
            {
                    echo "<script> alert('No puedes registrar a este usuario: $email');window.location= 'index.php' </script>";
            }

            } 

            ?>
    </main>
    
    <?php
    include("./componentes/footer.html");
    ?>
  
</body>
</html>