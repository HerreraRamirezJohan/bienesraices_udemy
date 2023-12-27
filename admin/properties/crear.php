<?php
    require '../../includes/app.php';
    $db = conectionDB();
    use App\Propiedad; 
    use Intervention\Image\ImageManager as Image;
    use Intervention\Image\Drivers\Gd\Driver;

    $manager = new Image(new Driver());

    $consulta = "SELECT * FROM seller;";
    $sellers = mysqli_query($db, $consulta);
    //Arreglo de mensajes de errores
    $errors = Propiedad::getErrores();
    //Variables
    $titulo = '';
    $price = '';
    $description = '';
    $rooms = '';
    $wc = '';
    $parking = '';
    $id_seller = '';
    //Variable imagen
    $imagen = ''; // se busca por el name

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $propiedad = new Propiedad($_POST);
        // Generar un nombre unico
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpeg";

        //subir la imagen con un corte
        if($_FILES['imagen']['tmp_name']){
            $image = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
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
            <fieldset>
                <legend>Informacion General</legend>
                <label for="titulo">Titulo:</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    placeholder="Titulo de la Propiedad" 
                    value="<?php echo $titulo ?>">

                <label for="price">Precio:</label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    placeholder="Precio propiedad" 
                    value="<?php echo $price ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <label for="description">Descripción:</label>
                <!-- No tiene atributo value -->
                <textarea name="description" id="description" ><?php echo $description ?></textarea>
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
                    value="<?php echo $rooms ?>">
                
                <label for="wc">Baños</label>
                <input 
                    type="number" 
                    id="wc" 
                    name="wc" 
                    placeholder="Número de baños: Ej 3" 
                    min="1" 
                    max="9" 
                    value="<?php echo $wc ?>">

                <label for="parking">Estacionamiento</label>
                <input 
                    type="number" 
                    id="parking" 
                    name="parking" 
                    placeholder="Número de estacionamientos: Ej 3" 
                    min="1" max="9" 
                    value="<?php echo $parking ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                <select name="seller" id="seller">
                    <option value="" selected >--Seleccione vendedor--</option>
                    <?php while ($seller = mysqli_fetch_assoc($sellers)) :?>
                        <option 
                            <?php echo $seller['id'] === $id_seller ? 'selected' : ''?>
                            value="<?php echo $seller['id']?>"><?php echo $seller['name'] . " " . $seller['lastname']?>
                        </option>
                    <?php endwhile;?>
                </select>
            </fieldset>

            <input type="submit" value="Registrar propiedad" class="boton-verde">
        </form>
    </main>

    <?php
        includeTemplate('footer')
    ?>
</body>
</html>