<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar contraseña
    $edad = (int) $_POST['edad'];
    $perfil = "usuario"; // Perfil predeterminado

    // Verificar si el correo ya está registrado
    $checkEmail = "SELECT * FROM usuario WHERE CORREO = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p>El correo ya está registrado.</p>";
    } else {
        // Insertar nuevo usuario
        $sql = "INSERT INTO usuario (CORREO, PASSWORD, EDAD, PERFIL) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $correo, $password, $edad, $perfil);

        if ($stmt->execute()) {
            echo "<p>Usuario registrado exitosamente.</p>";
        } else {
            echo "<p>Error al registrar el usuario.</p>";
        }
    }
}
?>