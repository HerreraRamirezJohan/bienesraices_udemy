<main class="contenedor seccion">
    <h1>Registrar Vendedores</h1>

    <?php foreach ($errors as $key => $error):?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach; ?>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <!-- enctype es muy importante para subir imagenes y archivos -->
    <form class="formulario" action="/vendedores/crear" method="POST">
        <?php include  __DIR__ . '/formulario.php';?>

        <input type="submit" value="Registrar vendedor" class="boton-verde">
    </form>
</main>