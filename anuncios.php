<?php
    require 'includes/app.php';
    includeTemplate('header');
?>

    <main class="contenedor seccion">

        <h2>Casas y Depas en Venta</h2>

        <?php
            $limit = 100;
            include 'includes/templates/anuncios.php';
        ?>
    </main>

    <?php
        includeTemplate('footer')
    ?>
</body>
</html>