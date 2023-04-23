<?php
    require 'includes/DB_conexion.php';
    require 'includes/funciones.php';
    // $errores = array();

    if(empty($_GET['userId'])){
        header('Location:index.php');
    }

    if(empty($_GET['token'])){
        header('Location:index.php');
    }
    $userId = $DB_conection->real_escape_string($_GET['userId']);
    $token = $DB_conection->real_escape_string($_GET['token']);

    if(!validarTokenPass($userId, $token)){
        echo "No se pudo verificar los datos.";
        exit();
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>.:Cambiar | GAME STORE:.</title>
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
    <form method="post" action="guarda_pass.php">
        <input type="hidden" name="userId" id="userId" value="<?php echo $userId; ?>" />
        <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
        <div class="contenedor contenedorB">
            <h4>Reestablecer Contraseña</h4>
            <div class="item2">           
                <i class="fas fa-unlock-alt"></i> <label for="nombre">NUEVA CONTRASEÑA</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input" name="pass01" />
            </div>
            
            <div class="item2">           
                <i class="fas fa-lock"></i> <label for="nombre">REPITE CONTRASEÑA</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input" name="pass02" />
            </div>

            <div class="item item--boton">
                <input class="btn--enviar" type="submit" value="GUARDAR"> 
            </div>
            
        </div>


    </form>
</body>
</html>