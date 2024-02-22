<?php
    if(!isset($_SESSION)){
        session_start();
    }
    $auth = $_SESSION['login'] ?? null;

    if(!ºisset($inicio)){
        $inicio = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="../build/css/app.css">
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="index.php">
                    <img src="../build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="../build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="../build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="nosotros.php">Nosotros</a>
                        <a href="anuncios.php">Anuncios</a>
                        <a href="blog.php">Blog</a>
                        <a href="contacto.php">Contacto</a>
                        <?php if($auth): ?>
                            <a href="cerrar-session.php">Cerrar Sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>
   
                
            </div> <!--.barra-->
            <?php if($inicio) {?>
                <h1>Venta de Casas y Departamentos  Exclusivos de Lujo</h1>
            <?php }?>
        </div>
    </header>

    <?php echo $content?>

    <footer class="footer seccion">
    <div class="contenedor contenedor-footer">
        <nav class="navegacion">
            <a href="nosotros.html">Nosotros</a>
            <a href="anuncios.html">Anuncios</a>
            <a href="blog.html">Blog</a>
            <a href="contacto.html">Contacto</a>
        </nav>
    </div>
    
    <p class="copyright">Todos los derechos Reservados <?php echo date('Y')?> &copy;</p>
</footer>

<script src="../build/js/bundle.min.js"></script>