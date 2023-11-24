<?php
    // importar db
    require_once 'includes/config/database.php';
    $db = conectionDB();
    //consultar las propiedades
    $query = "SELECT * FROM propertie limit $limit     ";
    $result = mysqli_query($db, $query);
?>

<div class="contenedor-anuncios">
    <?php while ($propiedad = mysqli_fetch_assoc($result)): ?>
            <div class="anuncio">
                <!-- <picture>
                    <source srcset="build/img/anuncio1.webp" type="image/webp">
                    <source srcset="build/img/anuncio1.jpg" type="image/jpeg"> -->
                    <img loading="lazy" src="/imagenes/<?php echo $propiedad['imagen'] ?>" alt="anuncio">
                <!-- </picture> -->
        
                <div class="contenido-anuncio">
                    <h3><?php echo $propiedad['title'] ?></h3>
                    <p><?php echo $propiedad['description'] ?></p>
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
                            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                            <p><?php echo $propiedad['rooms'] ?></p>
                        </li>
                    </ul>
        
                    <a href="anuncio.php?id=<?php echo $propiedad['id'] ?>" class="boton-amarillo-block">
                        Ver Propiedad
                    </a>
                </div><!--.contenido-anuncio-->
            </div><!--anuncio-->
        
        <?php endwhile; ?>
    </div> <!--.contenedor-anuncios-->

<?php
    //Cerrar la conexion
        mysqli_close($db);
?>