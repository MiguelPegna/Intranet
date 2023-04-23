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

    if($accesos==4){
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="../js/jquery-1.12.0.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="../js/editor.js"></script>
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/editor.css">
    <link rel="stylesheet" href="../css/Inicio.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        $(document).ready(function(){
            $('#box_post').Editor();

            $('#btn-ver').click(function(e){
                e.preventDefault();
                let preview = $('#box_post').Editor('getText');
                $('#vista').html(preview);
            });
        });
    </script>


    <title>Escribir Anuncio</title>
</head>
<body>
    <header>

        <?php include 'header.php';?>

    </header>

    <form method="post" action="save-post.php" enctype="multipart/form-data">
        <label for="titulo">Titulo</label>
        <input type="text" name="titulo-post"/><br/>
        <label for="titulo">Descripción</label>
        <input type="text" name="descripcion-post"/><br/>
        <!--Editor de texto enriquecido-->
		
		<textarea name="anuncio" id="box_post">

		</textarea>
		<br/>
        
        <button name="vista-previa" id="btn-ver">Vista Previa</button>
        <button name="publish-post">Publicar</button>
    </form><br/>
    <div class="vista" id="vista">

    </div>
</body>
</html>
 