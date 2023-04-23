<?php
    session_start();
    require '../includes/DB_conexion.php';
    require '../includes/mensajeria.php';
    #require 'includes/posting.php';

    $errores = array();
    $idUser = $_SESSION['id_usuario'];

    if(!isset($idUser)){
        header('Location: ../index.php');
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
                echo"<a href='index.php'>Regresar a Buzón</a>";
                exit; 
            }
            else{
                $errores[]="Error al enviar mensaje";
            }
        }
    } 

?>
<div class="error">
    <?php
        echo 'El mensaje no se puede enviar por lo siguiente'.'<br/>';
        echo listaErrores($errores); 
        echo 'Intenta otra vez';       
    ?>
</div>