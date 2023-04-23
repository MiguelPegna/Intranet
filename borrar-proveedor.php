<?php
    #script de validacion de datos para registro de usuarios
    session_start();
    require 'includes/DB_conexion.php';
    require 'includes/funciones.php';
    #require 'includes/posting.php';

    if(!isset($_SESSION['id_usuario'])){
        header('Location: index.php');
    }

    $idUser = $_SESSION['id_usuario'];
    $idProveedor = $_GET['id'];

    if(isset($idProveedor)){
        $sqlTrash="UPDATE proveedores SET Estado =0 WHERE Id_proveedor=$idProveedor";
        $actualiza = $DB_conection->query($sqlTrash);
        echo "<script>alert('El proveedor ha sido borrado'); </script>";
        echo "<script>setTimeout(\"location.href='proveedores.php'\",500); </script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar</title>
</head>
<body>
    
</body>
</html>