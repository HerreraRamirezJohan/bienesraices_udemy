<?php
    require '../../includes/app.php';
    $db = conectionDB();
    estaAutenticado();
    use Model\Propiedad;
    use Model\Vendedor;
    use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Drivers\Gd\Driver;

    $manager = new Image(new Driver());

    $sellers = Vendedor::all();
    //Arreglo de mensajes de errores
    $propiedad = new Propiedad;
    $errors = Propiedad::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $propiedad = new Propiedad($_POST['propiedad']);
        // Generar un nombre unico
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpeg";

        //subir la imagen con un corte
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
            $propiedad->setImagen($nombreImagen);
        }

        $errors = $propiedad->validar();

        if(empty($errors)){
            //guardar imagenes

            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }

            //Guardarla en la clase y en el servidor
            $image->toJpeg()->save(CARPETA_IMAGENES . $nombreImagen);
            
            $resultado = $propiedad->guardar();

            debug($resultado);

            if($resultado){
                //Redireccionar 
                header("Location: /admin?success=1");
            }else{
                $errors['DB error'] = "El servidor no responde";
            }
        }
    }

    includeTemplate('header');    
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <?php foreach ($errors as $key => $error):?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!-- enctype es muy importante para subir imagenes y archivos -->
        <form class="formulario" action="/admin/properties/crear.php" method="POST" enctype="multipart/form-data">
            <?php include  '../../includes/templates/formulario_propiedades.php';?>

            <input type="submit" value="Registrar propiedad" class="boton-verde">
        </form>
    </main>

    <?php
        includeTemplate('footer')
    ?>
</body>
</html>