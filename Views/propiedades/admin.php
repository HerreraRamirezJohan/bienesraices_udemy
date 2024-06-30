<main class="contenedor seccion">
    <h1>Administrador</h1>

    <?php
    $mensaje = mostrarNotificacion(intval($success));
    if ($mensaje) { ?>
        <p class='alerta success'><?php echo s($mensaje) ?></p>
    <?php } ?>

    <a href="/propiedades/crear" class="boton boton-verde">Nueva Propiedad</a>
    <a href="/vendedores/crear" class="boton boton-amarillo">Nuevo Vendedor</a>

    <table class="properties">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <!-- Mostrar los resultados -->
        <tbody>
            <?php foreach ($propiedades as $propertie) : ?>
                <tr>
                    <td><?php echo $propertie->id ?></td>
                    <td><?php echo $propertie->title ?></td>
                    <td><img src="/imagenes/<?php echo $propertie->imagen ?>" class="imagen-tabla"></td>
                    <td>$<?php echo $propertie->price ?></td>
                    <td>
                        <form method="POST" action="/propiedades/eliminar">
                            <input type="hidden" name="id" value="<?php echo $propertie->id ?>">
                            <input type="hidden" name="type" value="propertie">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">

                        </form>
                        <a href="/propiedades/actualizar?id=<?php echo $propertie->id ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h1>Administracion de Vendedores</h1>
    <table class="properties">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <!-- Mostrar los resultados -->
        <tbody>
            <?php foreach ($vendedores as $seller) : ?>
                <tr>
                    <td><?php echo s($seller->id) ?></td>
                    <td><?php echo s($seller->name . " " . $seller->lastname) ?></td>
                    <td><?php echo s($seller->phone) ?></td>
                    <td>
                        <form method="POST" action="/vendedores/eliminar">
                            <input type="hidden" name="id" value="<?php echo s($seller->id) ?>">
                            <input type="hidden" name="type" value="seller">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">

                        </form>
                        <a href="/vendedores/actualizar?id=<?php echo s($seller->id) ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>