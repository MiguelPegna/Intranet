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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stock.css">
    <link rel="stylesheet" href="css/buzon.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/88d10ff1ee.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="css/modalDoc.css"> 
    <script type='text/javascript' src='js/modalBorrar2.js'></script>  
    <title>Borrar</title>
</head>
<body>
    <!--modal-->
<div class="modal2" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-title"><h2>Borrar</h2></div>
            <i class="far fa-times-circle" id="close"></i>
            <div class="modal-body"> 
                <p>¿Estás seguro de querer borrar este cliente de la lista?</p>
                <div class="botones">
                    <a href="#" class="btn-red close" >CANCELAR</a>
                    <a href="borrar-formato.php?id=<?php echo $idDoc;?>" class="btn-green" >ACEPTAR</a>
                </div>
            </div> 
            <div class="modal-title"></div>
        </div>
    </div>  
</div>
    
</body>
</html>