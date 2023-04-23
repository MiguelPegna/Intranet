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
    $idDoc = $_GET['id'];

    if(isset($idDoc)){
        $sqlTrash="UPDATE formatos SET Estado =0 WHERE Id_doc=$idDoc";
        $actualiza = $DB_conection->query($sqlTrash);
        echo "<script>alert('El documento ha sido borrado'); </script>";
        echo "<script>setTimeout(\"location.href='formatos.php'\",500); </script>";
    }
?>

