<?php
    require '../../includes/funciones.php';
    if(!estaAutenticado()){
        header('Location: /');
    }
    require '../../includes/config/database.php';
    $db = conectionDB();

    $consulta = "SELECT * FROM seller;";
    $sellers = mysqli_query($db, $consulta);
    //Arreglo de mensajes de errores
    $errors = [];
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
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        //Esto se evita usando sentencias preparadas con PDO
        $titulo = mysqli_real_escape_string( $db, $_POST['title']);
        $price = mysqli_real_escape_string( $db, $_POST['price']);
        $description = mysqli_real_escape_string( $db, $_POST['description']);
        $rooms = mysqli_real_escape_string( $db, $_POST['rooms']);
        $wc = mysqli_real_escape_string( $db, $_POST['wc']);
        $parking = mysqli_real_escape_string( $db, $_POST['parking']);
        $id_seller = mysqli_real_escape_string( $db, $_POST['seller']);

        $imagen = $_FILES['imagen']; // se busca por el name
        echo "<pre>";
        var_dump($imagen);
        echo "</pre>";

        if(!$titulo)
            $errors["title"] = "Debes añadir un titulo";
        if(!$price)
            $errors["price"] = "Debes añadir un precio";
        if(!$description)
            $errors["description"] = "Debes añadir un descripción";
        if(strlen($description) < 30)
            $errors["description-len"] = "La descripcion debe ser de 30 caracteres";
        if(!$rooms)
            $errors["rooms"] = "Debes añadir una habitación";
        if(!$wc)
            $errors["wc"] = "Debes añadir un wc";
        if(!$parking)
            $errors["parking"] = "Debes añadir un estacionamiento";
        if(!$id_seller)
            $errors["seller"] = "Debes añadir un vendedor";
        if(!$imagen['name'])
            $errors["imagen"] = "Debes añadir un una imagen";

        //Validar por tamaño 1000Kb
        $max_size = 100;
        $medida = 1000 * $max_size;// multiplicamos por 1000 porque eso vale 1 kilobyte

        if($imagen['error'])
            $errors['imagen-size'] = "La imagen es muy pesada!";
        // Subir imagen
        

        // echo "<pre>";
        // var_dump($errors);
        // echo "</pre>";
        if(empty($errors)){
            //guardar imagenes
            // Crear una carpeta
            $carpetaImagenes = "../../imagenes/";
            if(!is_dir($carpetaImagenes))// Retorna si una carpeata existe o no
                mkdir($carpetaImagenes);
            // Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpeg";
            move_uploaded_file($imagen["tmp_name"], $carpetaImagenes . $nombreImagen);
            // Insertar datos a DB
            $query = "INSERT INTO propertie (title, price, imagen, description, rooms, wc, parking, id_seller) VALUES
                    ('$titulo', '$price', '$nombreImagen', '$description', '$rooms', '$wc', '$parking', '$id_seller')
                    ";
            
            $resultado = mysqli_query($db, $query);
    
            if($resultado){
                //Redireccionar 
                header("Location: /admin?success=1");
            }else{
                $errors['DB error'] = "El servidor no responde";
            }
        }
    }

    require '../../includes/funciones.php';
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