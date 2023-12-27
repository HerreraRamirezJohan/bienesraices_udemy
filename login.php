<?php
    require 'includes/app.php';
    $db = conectionDB();

    $errores = [];
    // Autenticar el usuario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(!$email)
            $errores[] = "El email es obligatorio o es invalido";
        if(!$password)
            $errores[] = "La contraseña es obligatoria o invalida";

        if(empty($errores)){
            // Revisar si el usuario existe
            $query = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($db, $query);

            if($result->num_rows){
                $user = mysqli_fetch_assoc($result);

                //verificar contraseña
                $auth = password_verify($password, $user['password']);

                if($auth){
                    session_start();
                    // La contraseña es correcta.
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');
                }else{
                    $errores [] = "El password es incorrecto";
                }
            }else{
                $errores[] = "El usuario no existe";
            }
        }
    }
    includeTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Secion</h1>

        <?php foreach ($errores as $key => $value): ?>
            <div class="alerta error">
                <?php echo $value ?>
            </div>
        <?php endforeach?>

        <form action="" class="formulario" method="post">
            <fieldset>

                <legend>Email y Password</legend>
                
                <label for="email">Email</label>
                <input type="text" placeholder="Email" id="email" name="email" required>
                
                <label for="password">Contraseña</label>
                <input type="password" placeholder="Contraseña [·# , 0-9, a-z]" id="password" name="password" required>
            </fieldset>

            <input class="btn boton-verde" type="submit" value="Iniciar Sesion">
        </form>
    </main>

<?php
    includeTemplate('footer')
?>