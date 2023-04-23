<?php
    #script de validacion de datos para registro de usuarios
    session_start();
    require 'includes/DB_conexion.php';
    require 'includes/funciones.php';

    if(!isset($_SESSION['id_usuario'])){
        header('Location: index.php');
    }

    $idUser = $_SESSION['id_usuario'];
    $accesos= $_SESSION['permisos'];


    if($accesos==3 or $accesos==4){
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Inicio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        .tabla{
            background-color: rgb(195, 195,195);
            font-size: 1.5rem;
            border-radius: 10px;
            padding: 15px;
        }

        .letra{
            color: #fff;
        }
        .empleados3{
            width: 100%;
        }
    </style>
    

    <title>.:Lista de empleados:.</title>

</head>
<body>
    <header>

        <?php include_once 'header.php';?>

    </header>

    <main class="contenedor main">
        <div class="portada">
            
        </div>
        <div class="servicios">
            <h2> Lista de empleados<br/>
            Buscar Empleado <input type="text" id="buscar" name="buscar" placeholder="Buscar empleado"/>
            </h2>
            <div class="servicios3">
                <div class="tabla">
                    <div id="empleados">
                    </div>  
                </div>
                
            </div>
        </div>    
        <?php include_once 'footer.html';?>   
    </main>
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="search.js"></script>
</body>
</html>