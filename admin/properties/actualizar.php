<?php
    require '../../includes/app.php';
    use App\Propiedad;
    use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Drivers\Gd\Driver;
    $manager = new Image(new Driver());
    estaAutenticado();
    
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /admin');
    }
    $db = conectionDB();

    //Obtener propiedad
    $propiedad = Propiedad::find($id);

    $consulta = "SELECT * FROM seller;";
    $sellers = mysqli_query($db, $consulta);
    //Arreglo de mensajes de errores
    $errors = Propiedad::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $args = $_POST['propiedad'];
        $propiedad->sincronizar($args);

        $nombreImagen = md5(uniqid(rand(), true)) . ".jpeg";

        $errors = $propiedad->validar();

        //subir la imagen con un corte
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
            $propiedad->setImagen($nombreImagen);
            //Guardarla en la clase y en el servidor
        }
        
        if(empty($errors)){
            
            $image->toJpeg()->save(CARPETA_IMAGENES . $nombreImagen);
            
            $resultado = $propiedad->guardar();
            if(!$resultado){
                //Redireccionar 
                header("Location: /admin?success=2");
            }else{
                $errors['DB error'] = "El servidor no responde";
            }
        }
    }
    includeTemplate('header');    
?>

    <main class="contenedor seccion">
        <h1>Actualizar</h1>

        <?php foreach ($errors as $key => $error):?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
        <?php endforeach; ?>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <!-- enctype es muy importante para subir imagenes y archivos -->
        <form class="formulario" action="" method="POST" enctype="multipart/form-data">
            <?php include  '../../includes/templates/formulario_propiedades.php';?>

            <input type="submit" value="Actualizar propiedad" class="boton-verde">
        </form>
    </main>

    <?php
        includeTemplate('footer')
    ?>
</body>
</html>