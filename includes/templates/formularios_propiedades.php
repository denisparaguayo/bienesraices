<fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input value="<?php echo s($propiedad->titulo); ?>" type="text" id="titulo" name="propiedad[titulo]" placeholder="Titulo de la Propiedad">

            <label for="precio">Precio:</label>
            <input value="<?php echo s($propiedad->precio); ?>" type="number" id="precio" name="propiedad[precio]" placeholder="Precio de la Propiedad">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">

            <?php if($propiedad->imagen){ ?>
                <img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small">
            <?php }?>

            <label for="descripcion">descripción:</label>
            <textarea name="propiedad[descripcion]" id="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>

        </fieldset>

        <fieldset>
            <legend>Información de la Propiedad</legend>

            <label for="habitaciones">Habitacion:</label>
            <input value="<?php echo s($propiedad->habitaciones); ?>" type="number" id="habitaciones" name="propiedad[habitaciones]" min="1" max="9">

            <label for="wc">Baños:</label>
            <input value="<?php echo s($propiedad->wc); ?>" type="number" id="wc" name="propiedad[wc]" min="1" max="9">

            <label for="estacionamiento">Estacionamiento:</label>
            <input value="<?php echo s($propiedad->estacionamiento); ?>" type="number" id="estacionamiento" name="propiedad[estacionamiento]" min="1" max="9">


        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
                
                <label for="vendedor">Vendedor</label>
                <select name="propiedad[vendedorId]" id="vendedor">
                <option selected value="">-- Seleccione --</option>
                <?php foreach($vendedores as $vendedor) { ?>
                    <option 
                    <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : ''; ?>
                    value="<?php echo s($vendedor->id); ?>"> <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?></option>
                <?php } ?>
                </select>

        </fieldset>