<?php
    #Script para cerrar sesion
    session_start();
    require 'DB_conexion.php';
    require 'funciones.php';
    $idUser = $_SESSION['id_usuario'];
    userOutline($idUser);
    session_destroy();
    header('location: ../index.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
</head>
<body>
</body>
</html>