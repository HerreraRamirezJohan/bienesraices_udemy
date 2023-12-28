<fieldset>
    <legend>Informacion General</legend>
    <label for="titulo">Titulo:</label>
    <input 
        type="text" 
        id="title" 
        name="title" 
        placeholder="Titulo de la Propiedad" 
        value="<?php echo s($propiedad->title) ?>">

    <label for="price">Precio:</label>
    <input 
        type="number" 
        id="price" 
        name="price" 
        placeholder="Precio propiedad" 
        value="<?php echo s($propiedad->price) ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

    <label for="description">Descripción:</label>
    <!-- No tiene atributo value -->
    <textarea name="description" id="description" ><?php echo s($propiedad->description) ?></textarea>
</fieldset>

<fieldset>
    <legend>Informacion Propiedad</legend>

    <label for="rooms">Habitaciones</label>
    <input 
        type="number" 
        id="rooms" 
        name="rooms"
        placeholder="Número de habitaciones: Ej 3" 
        min="1" 
        max="9" 
        value="<?php echo s($propiedad->rooms) ?>">
    
    <label for="wc">Baños</label>
    <input 
        type="number" 
        id="wc" 
        name="wc" 
        placeholder="Número de baños: Ej 3" 
        min="1" 
        max="9" 
        value="<?php echo s($propiedad->wc) ?>">

    <label for="parking">Estacionamiento</label>
    <input 
        type="number" 
        id="parking" 
        name="parking" 
        placeholder="Número de estacionamientos: Ej 3" 
        min="1" max="9" 
        value="<?php echo s($propiedad->parking) ?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <select name="seller" id="seller">
        <option value="" selected >--Seleccione vendedor--</option>
        <?php while ($seller = mysqli_fetch_assoc($sellers)) :?>
            <option 
                <?php echo $seller['id'] === $propiedad->id_seller ? 'selected' : ''?>
                value="<?php echo $seller['id']?>"><?php echo $seller['name'] . " " . $seller['lastname']?>
            </option>
        <?php endwhile;?>
    </select>
</fieldset>