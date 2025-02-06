<?php
    // Incluimos el archivo de conexión
    include('./componentes/conexion.php');

    // al darle al botón de buscar consultamos
    if (isset($_POST["buscar"])) {
        $num = 3; // Límite de registros por página
        $comienzo = isset($_POST['comienzo']) ? (int)$_POST['comienzo'] : 0;

        // Escapamos valores para evitar inyección SQL
        $denominacion = isset($_POST["denominacion"]) ? mysqli_real_escape_string($conexion, $_POST["denominacion"]) : '';
        $marca = isset($_POST["Marca"]) ? mysqli_real_escape_string($conexion, $_POST["Marca"]) : '';
        $alergenos = isset($_POST['alergias']) ? implode(",", $_POST['alergias']) : '';
        $formato = isset($_POST["formato"]) ? mysqli_real_escape_string($conexion, $_POST["formato"]) : '';
        $cantidad = isset($_POST["cantidad"]) ? mysqli_real_escape_string($conexion, $_POST["cantidad"]) : '';

        // Construcción dinámica de la consulta
        $sql = "SELECT * FROM productos WHERE 1=1"; // 1=1 para evitar errores en concatenación

        if (!empty($denominacion)) {
            $sql .= " AND denominacion LIKE '%$denominacion%'";
        }
        if (!empty($marca)) {
            $sql .= " AND marca = '$marca'";
        }
        if (!empty($alergenos)) {
            $sql .= " AND alergenos LIKE '%$alergenos%'";
        }
        if (!empty($formato)) {
            $sql .= " AND formato = '$formato'";
        }
        if (!empty($cantidad)) {
            $sql .= " AND cantidad = '$cantidad'";
        }

        // Agregamos el límite al final de la consulta
        $sql .= " LIMIT $comienzo, $num";

        // Ejecutamos la consulta
        $result = $conexion->query($sql);
        if ($result === false) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cerveza</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="./css/estilos.css">
</head>
<body>

<?php include("./componentes/header.html"); ?>

<main>
    <fieldset>
        <legend>Busca tu Cerveza</legend>
        <form action="secundaria.php" method="POST">
            <label>Denominación Cerveza:</label>
            <input type="text" name="denominacion" value="<?= htmlspecialchars($_POST['denominacion'] ?? '') ?>"/>

            <label>Marca:</label>
            <select name="Marca">
                <option value="Heineken" selected>Heineken</option>
                <option value="Mahou">Mahou</option>
                <option value="DAM">DAM</option>
                <option value="Estrella">Estrella Galicia</option>
                <option value="Alhambra">Alhambra</option>
                <option value="Cruzcampo">Cruzcampo</option>
                <option value="Artesana">Artesana</option>
            </select>

            <label>Alérgenos:</label>
            <div>
                <input type="checkbox" name="alergias[]" value="Gluten"> Gluten
                <input type="checkbox" name="alergias[]" value="Huevo"> Huevo
                <input type="checkbox" name="alergias[]" value="Cacahuete"> Cacahuete
                <input type="checkbox" name="alergias[]" value="Soja"> Soja
                <input type="checkbox" name="alergias[]" value="Lacteo"> Lácteo
                <input type="checkbox" name="alergias[]" value="Sulfitos"> Sulfitos
                <input type="checkbox" name="alergias[]" value="Sin"> Sin alérgenos
            </div>

            <label>Formato:</label>
            <select name="formato">
                <option value="lata" selected>lata</option>
                <option value="botella">botella</option>
                <option value="pack">pack</option>
            </select>

            <input type="submit" value="Buscar" name="buscar"/>
        </form>
    </fieldset>

    <?php if (isset($result) && $result->num_rows > 0): ?>
    <div class="container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Denominación</th>
                    <th>Marca</th>
                    <th>Formato</th>
                    <th>Cantidad</th>
                    <th>Alérgenos</th>
                    <th>Precio</th>
                    <th>Observaciones</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['denominacion'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['marca'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['formato'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['cantidad'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['alergenos'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['precio'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['observaciones'] ?? '') ?></td>
                    <td>
                        <a href='images/<?= htmlspecialchars($row['imagen'] ?? '') ?>'>
                            <img src='images/<?= htmlspecialchars($row['imagen'] ?? '') ?>' alt='Imagen' style='max-width: 100px;'>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div>
        <?php if ($comienzo > 0): ?>
            <a href="secundaria.php?comienzo=<?= max(0, $comienzo - $num) ?>">Anterior</a>
        <?php endif; ?>
        <a href="secundaria.php?comienzo=<?= $comienzo + $num ?>">Siguiente</a>
    </div>
    <?php else: ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>

</main>

<?php include("./componentes/footer.html"); ?>

</body>
</html>