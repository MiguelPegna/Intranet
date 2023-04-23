<?php
    require 'includes/DB_conexion.php';
    require 'includes/funciones.php';

    if(isset($_SESSION['id_usuario'])){
        header('Location:portal.php');
    }

    $errores = array();

    if(!empty($_POST)){
        $correo = $DB_conection->real_escape_string($_POST['email']);
        
        if(!esMail($correo)){
            $errores[] = 'No es un E-mail valido';
        }
        if(mailExiste($correo)){
            $userId = obtenerValor('Id_empleado', 'Email', $correo);
            $nombre = obtenerValor('Nombre', 'Email', $correo);
            $token = creaTokenPass($userId);

            $url ='http://'.$_SERVER["SERVER_NAME"].'/intranet/cambiarPass.php?userId='.$userId.'&token='.$token;
            $asunto='Recuperar password de acceso Game Store';
            $mensaje="Hola $nombre: <br/>Para recuperar password, haz click en el sig enlace: <a href='$url'>Click Aqui</a>";

            if(enviarMail($correo, $nombre, $asunto, $mensaje)){
                echo"Se ha enviado el e-mail a tu correo para restablecer tu password". "<br/>";
                echo"<a href='index.php'>Iniciar Sesión</a>";
                exit; 
            }
            else{
                $errores[]="Error al enviar el e-mail de recuperación";
            }
        }
        else{
            $errores[]="No existe registro con ese E-mail";
        }
    }



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>.:Iniciar Sesión | GAME STORE:.</title>
    <script src="https://www.google.com/recaptcha/api.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/forms.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-RXf+QSDCUQs5uwRKaDoXt55jygZZm2V++WUZduaU/Ui/9EGp3f/2KZVahFZBKGH0s774sd3HmrhUy+SgOFQLVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script type="text/javascript" src="js/validaForm.js"></script>
</head>

<body>
<form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">

    <div class="contenedor contenedorB">
    <h4>Recuperar Contraseña</h4>
        <div class="item">           
            <i class="far fa-envelope"></i> <label for="nombre">E-MAIL</label><span class="obligatorio">&nbsp;*</span><br/>
            <input type="text" class="form--input" name="email" />
        </div>

        <div class="item item--boton">
            <input class="btn--enviar" type="submit" value="ENVIAR"> 
        </div>
            <a href="index.php">Iniciar Sesión</a><br>

        <?php 
            echo listaErrores($errores);
        ?>
       
    </div>
</form>
    
</body>
</html>