<?php
    require '../includes/app.php';
    estaAutenticado();
    
    use App\Propiedad;

    //Metodo para obtener todas las propiedades
    $propiedades = Propiedad::all();

    // Mensaje
    // remplazo del isset
    // $success = isset($_GET["success"]) ? $_GET['success'] : null;
    $success = $_GET["success"] ?? null; //Este place holder busca el valor, si no existe le asigna null

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];

        $id = filter_var($id, FILTER_VALIDATE_INT);//VALIDAMOS QUE NO INGRESEN CODIGO SQL 

        if($id){
            //Eliminar el archivo
            $query = "SELECT imagen FROM propertie WHERE id = $id";
            $result = mysqli_query($db, $query);
            $propertie = mysqli_fetch_assoc($result);

            unlink('../imagenes/' . $propertie['imagen']);

            //Eliminar la propiedad
            $query = "DELETE FROM propertie WHERE id = $id";
            $result = mysqli_query($db, $query);

            if($result){
                header('location: /admin?success=3');
            }
        }
    }

    //Template header
    includeTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador</h1>
        <?php if($success == 1): ?>
            <p class="alerta success">Anuncio de Propiedad creado correctamente.</p>
        <?php elseif ($success == 2): ?>
            <p class="alerta success">Anuncio de Propiedad actualizado correctamente.</p>
        <?php elseif ($success == 3): ?>
            <p class="alerta success">Anuncio de Propiedad eliminado correctamente.</p>
        <?php endif; ?>
        <a href="/admin/properties/crear.php" class="boton boton-verde">Nueva Propiedad</a>

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
                <?php foreach ($propiedades as $propertie): ?>
                    <tr>
                    <td><?php echo $propertie->id ?></td>
                    <td><?php echo $propertie->title ?></td>
                    <td><img src="/imagenes/<?php echo $propertie->imagen ?>" class="imagen-tabla"></td>
                    <td>$<?php echo $propertie->price ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $propertie->id ?>">
                            <input type="submit" value="Eliminar" class="boton-rojo-block">

                        </form>
                        <a href="/admin/properties/actualizar.php?id=<?php echo $propertie->id ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>

    <?php
        // Cerrar la conexion
        mysqli_close($db);
        //footer
        includeTemplate('footer');
    ?>
</body>
</html>