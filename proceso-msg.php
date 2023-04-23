<?php
    session_start();
    require 'includes/DB_conexion.php';
    require 'includes/mensajeria.php';
    #require 'includes/posting.php';

    $errores = array();
    $idUser = $_SESSION['id_usuario'];

    if(!isset($idUser)){
        header('Location: index.php');
    }

    if(!empty($_POST)){
        $varPara = $DB_conection->real_escape_string($_POST['tpara']);
        $varAsunto = $DB_conection->real_escape_string($_POST['tasunto']);
        $varMensaje = $DB_conection->real_escape_string($_POST['tmensaje']);

        $queryPara="SELECT Id_empleado, Nombre, Apellido_p, Departamento FROM usuarios WHERE Nombre= '$varPara'";
	    $resultado=$DB_conection ->query($queryPara);
       
        if(revCampos($varPara, $varAsunto, $varMensaje)){
            $errores[] ="Llena TODOS los campos";
        }

        if(!encontrarUsuario($varPara)){
            $errores[] ="El usuario a quien quieres mandar mensaje no existe en la base de datos";
        }
    

        if(count($errores)==0){
            $idPara =$resultado-> fetch_array(MYSQLI_BOTH);
            $cambio = $idPara['Id_empleado'];
            // echo $cambio;
            if(enviarMensaje($idUser, $cambio, $varAsunto, $varMensaje)){
                echo'Se ha mandado el mensaje correctamente a: ' .$varPara . '<br/>';
                echo "<script>setTimeout(\"location.href='inbox.php'\",1000); </script>";
                exit; 
            }
            else{
                $errores[]="Error al enviar mensaje";
            }
        }
    } 

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>.:Alert:.</title>
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
    <div class="contenedor contenedorB">
        <div class="item">     
            
                <?php
                    echo 'El mensaje no se envio por lo sig.'.'<br/>';
                    echo listaErrores($errores); 
                    echo '<a href="nuevo-msg.php">Intenta otra vez</a>';       
                ?>
            

        </div>

    </div>

</body>
</html>
