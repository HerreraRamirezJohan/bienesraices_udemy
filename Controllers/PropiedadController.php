<?php

namespace Controller;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class PropiedadController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::all();
        $resultado = $_GET['success'] ?? null;
        $sellers = Vendedor::all();

        $router->view('propiedades/admin', [
            'propiedades' => $propiedades,
            'success' => $resultado,
            'vendedores' => $sellers
        ]);
    }
    public static function create(Router $router)
    {
        $sellers = Vendedor::all();
        $propiedad = new Propiedad();
        $errors = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $manager = new Image(new Driver());
            $propiedad = new Propiedad($_POST['propiedad']);
            // Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpeg";

            //subir la imagen con un corte
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);
            }
            
            $errors = $propiedad->validar();
            
            if (empty($errors)) {
                //guardar imagenes
                
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }
                
                //Guardarla en la clase y en el servidor
                $image->toJpeg()->save(CARPETA_IMAGENES . $nombreImagen);

                $resultado = $propiedad->guardar();

                if ($resultado) {
                    //Redireccionar 
                    header("Location: /admin?success=1");
                } else {
                    $errors['DB error'] = "El servidor no responde";
                }
            }
        }
        $router->view('propiedades/crear', [
            'propiedad' => $propiedad,
            'sellers' => $sellers,
            'errors' => $errors,
        ]);
    }

    public static function view(Router $router)
    {
        $id = checkUrl('/admin');

        $sellers = Vendedor::all();
        $propiedad = Propiedad::find($id);
        $errors = Propiedad::getErrores();

        $router->view('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errors' => $errors,
            'sellers' => $sellers,
        ]);
    }
    public static function update()
    {
        $id = checkUrl('/admin');

        $sellers = Vendedor::all();
        $propiedad = Propiedad::find($id);
        $errors = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $args = $_POST['propiedad'];
            $propiedad->sincronizar($args);

            $nombreImagen = md5(uniqid(rand(), true)) . ".jpeg";

            $errors = $propiedad->validar();

            //subir la imagen con un corte
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
                $propiedad->setImagen($nombreImagen);
                //Guardarla en la clase y en el servidor
            }

            if (empty($errors)) {
                if (!is_null($image)) {
                    $image->toJpeg()->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $resultado = $propiedad->guardar();
                if ($resultado) {
                    //Redireccionar  
                    header("Location: /admin?success=2");
                } else {
                    $errors['DB error'] = "El servidor no responde";
                }
            }
        }

        $router->view('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errors' => $errors,
            'sellers' => $sellers,
        ]);
    }

    public static function destroy()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT); //VALIDAMOS QUE NO INGRESEN CODIGO SQL 

            if ($id) {
                $propiedad = Propiedad::find($id);
                $url = './imagenes/' . $propiedad->imagen;
                // debug($url);
                unlink($url);
                $propiedad->eliminar();
            }
        }
    }
}
