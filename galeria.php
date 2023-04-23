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
    $accesos= $_SESSION['permisos'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/Inicio.css">
    <link rel="stylesheet" href="css/mensajes.css">
    <title>.:Galerias || Game Store:.</title>
</head>
<body>
    <header>

        <?php include_once 'header.php';?>

    </header>

    <main class="contenedor main">
        <div class="portada">
            <p>aqui va la imagen de portada</p>
        </div>
        <div class="servicios">
        <?php
            $imgs= dir('fotos');
            while(($img= $imgs->read()) !== false){
               if(eregi('jpg', $img )){
                  echo"<img src='fotos/$img' width='250' heigth='250'>";

               }
            }
        ?>
            
        </div>

    </main>
</body>
</html>