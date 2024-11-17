<!DOCTYPE html>
<html>
<head>
    <title>Casillas</title>
</head>
<body>
    <h1>Tabla de una fila con casillas de verificación(Formulario 2)</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $size = intval($_POST["num"]);
        $size = ($size > 20) ? 20 : $size; // nos aseguramos que el tamaño no es mayor de 20

        //creamos el formulario con la tabla de casillas checkbox
        echo "<form action='marcadas.php' method='post'>";
        echo "<table border='1' style='border-collapse: collapse;'>";
            //creamos la fila
            echo "<tr>";
            for ($col = 1; $col <= $size; $col++) {//hacemos tantas columnas como indicamos anteriormente
                echo "<td'>";
                echo "<input type='checkbox' name='selected[]' value='$col'>$col";
                echo "</td>";
            }
            echo "</tr>";
        echo "</table>";
        echo "<input type='hidden' name='size' value='$size'>";
        echo "<br><button type='submit'>Contar</button>";
        echo "<br><button type='reset'>Borrar</button>";
        echo "</form>";
        echo "<A HREF='javascript:history.back()'>Volver al formulario</A> </P>";
    } else {
        echo "Por favor, regrese a la página anterior para ingresar el tamaño de la tabla.";
    }
    ?>
</body>
</html>