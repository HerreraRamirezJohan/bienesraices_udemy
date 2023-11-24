<?php

    // importar db
    require_once 'includes/config/database.php';
    $db = conectionDB();
    //consultar las propiedades
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    $query = "SELECT * FROM propertie where id = $id";
    $result = mysqli_query($db, $query);
    if(!$result->num_rows){
        header('Location: /');
    }
    $propiedad = mysqli_fetch_assoc($result);

    require 'includes/funciones.php';
    includeTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad['title'] ?></h1>

        <!-- <picture>
            <source srcset="build/img/destacada.webp" type="image/webp">
            <source srcset="build/img/destacada.jpg" type="image/jpeg"> -->
            <img loading="lazy" src="/imagenes/<?php echo $propiedad['imagen'] ?>" alt="imagen de la propiedad">
        <!-- </picture> -->

        <div class="resumen-propiedad">
            <p class="precio"><?php echo $propiedad['price'] ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc'] ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['parking'] ?></p>
                </li>
                <li>
                    <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad['rooms'] ?></p>
                </li>
            </ul>

            <p>Proin consequat viverra sapien, malesuada tempor tortor feugiat vitae. In dictum felis et nunc aliquet molestie. Proin tristique commodo felis, sed auctor elit auctor pulvinar. Nunc porta, nibh quis convallis sollicitudin, arcu nisl semper mi, vitae sagittis lorem dolor non risus. Vivamus accumsan maximus est, eu mollis mi. Proin id nisl vel odio semper hendrerit. Nunc porta in justo finibus tempor. Suspendisse lobortis dolor quis elit suscipit molestie. Sed condimentum, erat at tempor finibus, urna nisi fermentum est, a dignissim nisi libero vel est. Donec et imperdiet augue. Curabitur malesuada sodales congue. Suspendisse potenti. Ut sit amet convallis nisi.</p>

            <p><?php echo $propiedad['description'] ?></p>
        </div>
    </main>

    <?php
        includeTemplate('footer')
    ?>
</body>
</html>

<?php
    mysqli_close($db);
?>