<fieldset>
    <legend>Información General</legend>
    <label for="nombre">Nombre</label>
    <input type="text" name="vendedor[nombre]" id="nombre" placeholder="Nombre del Vendedor" value="<?php echo s($vendedor->nombre); ?>">
    
    <label for="apellido">Apellido</label>
    <input type="text" name="vendedor[apellido]" id="apellido" placeholder="Apellido del Vendedor" value="<?php echo s($vendedor->apellido); ?>">

</fieldset>
<fieldset>
    <legend>Información Extra</legend>

    <label for="telefono">Telefono</label>
    <input type="number" name="vendedor[telefono]" id="telefono" placeholder="Telefono del Vendedor" value="<?php echo s($vendedor->telefono); ?>">
</fieldset>