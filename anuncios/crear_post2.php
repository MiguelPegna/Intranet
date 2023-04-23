<?php
    #script de validacion de datos para registro de usuarios
    require '../includes/DB_conexion.php';
    require '../includes/funciones.php';
    #require 'includes/posting.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="ckeditor/ckeditor.js"></script>
	<script src="ckfinder/ckfinder.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="save-post">
        <label for="titulo">Titulo</label>
        <input type="text" name="titulo-post"/><br/>
        <label for="titulo">Descripción</label>
        <input type="text" name="descripcion-post"/><br/>
        <!--Editor de texto enriquecido-->
		
		<textarea name="anuncio" id="box_post">

		</textarea>
		<br/>
        



        <button name="vista-previa">Vista Previa</button>
        <button name="publish-post">Publicar</button>
    </form>
</body>
<script type="text/javascript">
    CKEDITOR.replace("box_post");
		
</script>
</html>
