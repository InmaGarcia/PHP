
  <h1>Inserción de Cervezas</h1>
    <p>Introduzca los datos de las cervezas:</p>
    <fieldset>
      <form action="admin.php" method="POST" enctype="multipart/form-data">
        <label>Denominación Cerveza:</label>
        <input type="text" name="denominacion" value="" />

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

        <label>Alérgenos:</label>
        <input type="checkbox" name="alergias[]" value="Gluten" />
        <label>Gluten</label>
        <input type="checkbox" name="alergias[]" value="Huevo" />
        <label>Huevo</label>
        <input type="checkbox" name="alergias[]" value="Cacahuete" />
        <label>Cacahuete</label>
        <input type="checkbox" name="alergias[]" value="Soja" />
        <label>Soja</label>
        <input type="checkbox" name="alergias[]" value="Lacteo" />
        <label>Lacteo</label>
        <input type="checkbox" name="alergias[]" value="Sulfitos" />
        <label>Sulfitos</label>
        <input type="checkbox" name="alergias[]" value="Sin" />
        <label>Sin alérgenos</label>

        <div class="saltolinea"></div>

        <label>Fecha Consumo:</label>
        <input type="date" id="caducidad" name="caducidad" />

        <div class="saltolinea"></div>

        <label>Foto:</label>
        <input type="file" name="imagen" id="imagen" />

        <div class="saltolinea"></div>

        <label>Precio:</label>
        <input type="number" id="precio" name="precio" />

        <div class="saltolinea"></div>

        <label>Observaciones:</label>
        <textarea
          id="Obs"
          name="Obs"
          style="width: 40%; height: 40px"
        ></textarea>

        <div class="saltolinea"></div>

        <input type="submit" value="Insertar Cerveza" id="btn-submit"/>
      </form>
    </fieldset>
