<?php
require '../../includes/app.php';
use App\Vendedor;
estaAutenticado();

//Validar que id sea valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
if(!$id){
    header('Location: /admin');
}

$seller = Vendedor::find($id);

$errors = Vendedor::getErrores();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $args = $_POST['seller'];
    $seller->sincronizar($args);

    $errors = $seller->validar();

    if(empty($errors)){
        $resultado = $seller->guardar();

        if($resultado){
           header("Location: /admin?success=2");
        }
    }
}

includeTemplate('header'); 

?>

<main class="contenedor seccion">
    <h1>Actualizar Vendedores</h1>

    <?php foreach ($errors as $key => $error):?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach; ?>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <!-- enctype es muy importante para subir imagenes y archivos -->
    <form class="formulario" method="POST">
        <?php include  '../../includes/templates/formulario_vendedores.php';?>

        <input type="submit" value="Actualizar vendedor" class="boton-verde">
    </form>
</main>

<?php
    includeTemplate('footer')
?>