<fieldset>
    <legend>Informacion General</legend>
    <label for="titulo">Titulo:</label>
    <input 
        type="text" 
        id="title" 
        name="propiedad[title]" 
        placeholder="Titulo de la Propiedad" 
        value="<?php echo s($propiedad->title) ?>">

    <label for="price">Precio:</label>
    <input 
        type="number" 
        id="price" 
        name="propiedad[price]" 
        placeholder="Precio propiedad" 
        value="<?php echo s($propiedad->price) ?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">

    <?php if($propiedad->imagen): ?>
        <img src="/imagenes/<?php echo s($propiedad->imagen)?>" alt="" class="imagen-small">
    <?php endif; ?>

    <label for="description">Descripción:</label>
    <!-- No tiene atributo value -->
    <textarea name="propiedad[description]" id="description" ><?php echo s($propiedad->description) ?></textarea>
</fieldset>

<fieldset>
    <legend>Informacion Propiedad</legend>

    <label for="rooms">Habitaciones</label>
    <input 
        type="number" 
        id="rooms" 
        name="propiedad[rooms]"
        placeholder="Número de habitaciones: Ej 3" 
        min="1" 
        max="9" 
        value="<?php echo s($propiedad->rooms) ?>">
    
    <label for="wc">Baños</label>
    <input 
        type="number" 
        id="wc" 
        name="propiedad[wc]" 
        placeholder="Número de baños: Ej 3" 
        min="1" 
        max="9" 
        value="<?php echo s($propiedad->wc) ?>">

    <label for="parking">Estacionamiento</label>
    <input 
        type="number" 
        id="parking" 
        name="propiedad[parking]" 
        placeholder="Número de estacionamientos: Ej 3" 
        min="1" max="9" 
        value="<?php echo s($propiedad->parking) ?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <select name="propiedad[id_seller]" id="seller">
        <option value="" selected >--Seleccione vendedor--</option>
        <?php while ($seller = mysqli_fetch_assoc($sellers)) :?>
            <option 
                <?php echo $seller['id'] === $propiedad->id_seller ? 'selected' : ''?>
                value="<?php echo $seller['id']?>"><?php echo $seller['name'] . " " . $seller['lastname']?>
            </option>
        <?php endwhile;?>
    </select>
</fieldset>