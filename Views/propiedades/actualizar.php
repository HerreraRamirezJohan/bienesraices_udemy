<main class="contenedor seccion">
    <h1>Actualizar Propopiedad</h1>
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php foreach ($errors as $key => $error) : ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php include __DIR__ . '/formulario.php' ?>
        <input type="submit" value="Actualizar" class="boton-verde">
    </form>
</main>