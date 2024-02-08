<fieldset>
    <legend>Informacion General</legend>
    <label for="nombre">Nombre:</label>
    <input 
        type="text" 
        id="nombre" 
        name="seller[name]" 
        placeholder="Nombre del vendedor(a)" 
        value="<?php echo s($seller->name) ?>">
    <label for="lastname">Apellido:</label>
    <input 
        type="text" 
        id="lastname" 
        name="seller[lastname]" 
        placeholder="Apellido del vendedor(a)" 
        value="<?php echo s($seller->lastname) ?>">
</fieldset>

<fieldset>
    <legend>Informacion extra</legend>

    <label for="phone">Telefono:</label>
    <input 
        type="text" 
        id="phone" 
        name="seller[phone]" 
        placeholder="Telefono del vendedor(a)" 
        value="<?php echo s($seller->phone) ?>">
</fieldset>