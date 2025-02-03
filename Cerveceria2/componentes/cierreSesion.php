<?php
//cojo la sesion y la cierro
    session_start();
    echo "<script>alert('Has cerrado la sesión {$_SESSION['email']}');</script>";
    session_destroy();
    echo "<script>window.location= './index.php'</script>";
?>