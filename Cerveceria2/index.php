<?php
    include('./componentes/conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gustosa</title>
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
    include("./componentes/header.html");
    ?>
    <main>
        <fieldset>
          <legend>Busca tu Cerveza</legend>
          <form action="secundaria.php" method="POST" enctype="multipart/form-data">

            <div class="saltolinea"></div>

            <label>Marca:</label>
            <select id="Marca" name="Marca" size="1">
              <option value="Heineken" selected>Heineken</option>
              <option value="Mahou">Mahou</option>
              <option value="DAM">DAM</option>
              <option value="Estrella">Estrella Galicia</option>
              <option value="Alhambra">Alhambra</option>
              <option value="Cruzcampo">Cruzcampo</option>
              <option value="Artesana">Artesana</option>
            </select>

            <div class="saltolinea"></div>

            <label>Tipo de Cerveza:</label>
            <input type="radio" id="lager" name="tipo" value="lager" />
            <label>LAGER</label>
            <input type="radio" id="pale" name="tipo" value="pale" />
            <label>PALE ALE</label>
            <input type="radio" id="negra" name="tipo" value="negra" />
            <label>CERVEZA NEGRA</label>
            <input type="radio" id="abadia" name="tipo" value="abadia" />
            <label>ABADIA</label>
            <input type="radio" id="rubia" name="tipo" value="rubia" />
            <label>RUBIA</label>

            <div class="saltolinea"></div>

            <label>Formato:</label>
            <select id="formato" name="formato" size="1">
              <option value="lata" selected>lata</option>
              <option value="botella">botella</option>
              <option value="pack">pack</option>
            </select>

            <div class="saltolinea"></div>

            <label>Tamaño:</label>
            <select id="tamanyo" name="tamanyo" size="1">
              <option value="botellin" selected>botellin</option>
              <option value="tercio">tercio</option>
              <option value="media">media</option>
              <option value="litrona">litrona</option>
              <option value="pack">pack</option>
            </select>

            <div class="saltolinea"></div>

            <input type="submit" value="Buscar" id="btn-submit"/>
          </form>
              <div class="saltolinea"></div>
              <!-- Codigo php para buscar la cerveza en la bbdd y pintarla -->
              <div></div>
        </fieldset>
    </main>
    <?php
    include("./componentes/footer.html");
    ?>
  </body>
</html>
