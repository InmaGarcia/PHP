<!DOCTYPE html>
<html>
<head>
    <title>Casillas Marcadas</title>
</head>
<body>
    <h1>Tabla de una fila con casillas de verificación(Resultado)</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $selected = isset($_POST['selected']) ? $_POST['selected'] : [];
        $size = intval($_POST["size"]);

        echo "<p>Ha marcado <b>" . count($selected) . "</b> casillas de <b>".$size."</b>:</p>";

        if (!empty($selected)) {
            foreach ($selected as $value) {
                echo "<b>   Casilla $value</b>";
            }
        } else {
            echo "<p>No seleccionaste ninguna casilla.</p>";
        }
    } else {
        echo "Por favor, regrese a la página anterior para interactuar con la tabla.";
    }
    echo "<A HREF='javascript:history.back()'>Volver a la tabla</A> </P>";
    echo "<A HREF='index.html'>Volver al formulario Inicial</A> </P>";
    ?>
</body>
</html>