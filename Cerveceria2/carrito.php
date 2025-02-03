<?php
include('./componentes/conexion.php');

// Función para eliminar un artículo de la cesta
function eliminarFila($indice) {
    $cesta = isset($_SESSION['cesta']) ? $_SESSION['cesta'] : array();
    if ($indice >= 0 && $indice < count($cesta)) {
        array_splice($cesta, $indice, 1);
        $_SESSION['cesta'] = $cesta;
        // Redirige de nuevo a la página del carrito para mostrar el carrito actualizado
        header('Location: carrito.php');
        exit();
    }
}

// Verifica si se ha enviado el índice del artículo a eliminar
if (isset($_GET['eliminar'])) {
    $indiceEliminar = $_GET['eliminar'];
    eliminarFila($indiceEliminar);
}

// Función para calcular el total del carrito de la compra
function calcularTotal() {
    $cesta = isset($_SESSION['cesta']) ? $_SESSION['cesta'] : array();
    $total = 0;
    foreach ($cesta as $libro) {
        $total += $libro['precio'];
    }
    $_SESSION['total_compra'] = number_format($total, 2);
    return number_format($total, 2);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Carrito</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 10px;
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Tu Cesta</h2>
    <?php
    $cesta = isset($_SESSION['cesta']) ? $_SESSION['cesta'] : array();
    if (empty($cesta)) {
        echo '<p>Tu cesta está vacía</p>';
    } else {
        echo '<table class="table table-dark table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Titulo</th>';
        echo '<th scope="col">Autor</th>';
        echo '<th scope="col">Portada</th>';
        echo '<th scope="col">Precio</th>';
        echo '<th scope="col">Eliminar artículo</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Itera sobre los elementos del carrito y agregar filas a la tabla
        foreach ($cesta as $i => $libro) {
            echo '<tr>';
            echo '<td>' . $libro['titulo'] . '</td>';
            echo '<td>' . $libro['autor'] . '</td>';
            echo '<td><img src="' . $libro['portada'] . '" alt="Portada de ' . $libro['titulo'] . '" style="max-width: 100px; max-height: 100px;"></td>';
            echo '<td>' . $libro['precio'] . '€</td>';
            echo "<td><a href='carrito.php?eliminar=$i' class='btn btn-danger' role='button'>&#128465; Eliminar</a></td>";
            echo '</tr>';
        }

        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr>';
        echo '<td colspan="3"></td>';
        echo '<td>Total: ' . calcularTotal() . '€</td>';
        echo '<td></td>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';

        echo '<a href="consultar.php" class="btn btn-primary">Seguir comprando</a> ';
        echo '<a href="finalizar.php" class="btn btn-success" data-toggle="modal" data-target="#confirmarModal">Finalizar compra</a>';
     
    }
    ?>
</body>
</html>
