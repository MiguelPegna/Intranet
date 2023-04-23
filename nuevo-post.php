<?php
    #script de validacion de datos para registro de usuarios
    session_start();
    require 'includes/DB_conexion.php';
    #require 'includes/funciones.php';
    require 'includes/posting.php';

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
    <script src="js/jquery-1.12.0.js"></script>
	<script src="js/editor.js"></script>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/editor.css">
    <link rel="stylesheet" href="css/stock.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        //Script para la vista previa
        $(document).ready(function(){
            $('#tmensaje').Editor();

            $('#btn-ver').click(function(e){
                e.preventDefault();
                let preview = $('#tmensaje').Editor('getText');
                $('#vista').html(preview);
            });

            $('#btn-send').click(function(e){
                e.preventDefault();
                $('#tmensaje').text($('#tmensaje').Editor('getText'));
                $('#frm-post').submit();
            });
        });


    </script>


    <title>Escribir Anuncio</title>
</head>
<body>
    <header>

        <?php include 'header2.php';?>

    </header>
    <main class="contenedor main">
        <div class="portada">
        <a href="blog.php" class="btn btn-warning">REGRESAR AL BLOG</a><br/>
        </div>   
            
        
        <div class="servicios">
            <div class="mensajesenviados">
                <div class="titulomen">
                    <h2>Escribe tu anuncio</h2>
                </div>
                    
                <form method="post" id="frm-post" action="save-post.php" enctype="multipart/form-data"">
                    <label for="titulo"><h3><strong>Titulo</strong></h3></label>
                    <input type="text" name="ttitulo"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="titulo"><h3><strong>Descripción</strong></h3></label>
                    <input type="text" name="tdescripcion" size="50"/><br/>
                    <!--Editor de texto enriquecido-->
                    
                    <textarea name="tmensaje" id="tmensaje">

                    </textarea>
                    <br/>
            
                    <button name="vista-previa" id="btn-ver" class="btn btn-info">Vista Previa</button>&nbsp;&nbsp;&nbsp;
                    <button name="publish-post" id="btn-send" class="btn btn-success">Publicar Entrada</button>
                </form><br/>

                <div class="vista" id="vista">

                </div>
                 
            </div>
        </div>
        <?php include_once 'footer.html';?>

    </main>   
</body>
</html>
