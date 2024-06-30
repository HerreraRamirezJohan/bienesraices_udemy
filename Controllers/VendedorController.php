<?php

namespace Controller;

use Model\Vendedor;
use MVC\Router;

class VendedorController
{
    public static function create(Router $router)
    {
        $seller = new Vendedor();
        $errors = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $seller = new Vendedor($_POST['seller']);
            $errors = $seller->validar();

            if (empty($errors)) {
                $seller->guardar();
            }
        }

        return $router->view('vendedores/crear', [
            'seller' => $seller,
            'errors' => $errors,
        ]);
    }
    public static function update(Router $router)
    {
        $id = checkUrl('/admin');

        $seller = Vendedor::find($id);
        $errors = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST['seller'];
            $seller->sincronizar($args);

            $errors = $seller->validar();

            if (empty($errors)) {
                $resultado = $seller->guardar();

                if ($resultado) {
                    header("Location: /admin?success=2");
                }
            }
        }
        return $router->view('vendedores/crear', [
            'seller' => $seller,
            'errors' => $errors,
        ]);
    }
    public static function destroy()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT); //VALIDAMOS QUE NO INGRESEN CODIGO SQL 

            if ($id) {
                $seller = Vendedor::find($id);
                $seller->eliminar();
            }
        }
    }
}
