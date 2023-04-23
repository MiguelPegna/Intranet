<?php
    #script de validacion de datos para envio de mensajes
    session_start();
    require '../includes/DB_conexion.php';
    require '../includes/mensajeria.php';
    #require 'includes/posting.php';

    $errores = array();
    $idUser = $_SESSION['id_usuario'];

    if(!isset($idUser)){
        header('Location: ../index.php');
    }

    $queryPara="SELECT Id_empleados FROM usuarios WHERE Nombre= 'Guadalupe'";
	$resultado=$DB_conection ->query($queryPara);

    $idPara =$resultado-> fetch_array(MYSQLI_BOTH);
            $cambio = $idPara['id_empleado'];
            echo $cambio;


?>