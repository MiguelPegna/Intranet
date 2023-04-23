<?php
    #script de validacion de datos para envio de mensajes
    session_start();
    require '../includes/DB_conexion.php';
    require '../includes/mensajeria.php';
    $errores = array();
    $idUser = $_SESSION['id_usuario'];
    $accesos= $_SESSION['permisos'];

    if(!isset($idUser)){
        header('Location: ../index.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/Inicio.css">
    <link rel="stylesheet" href="../css/mensajes.css">

    <script src="../js/jquery-1.12.0.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="../js/editor.js"></script>
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/editor.css">
    <!-- Include stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <script type="text/javascript">
        $(document).ready(function(){
            $('#tmensaje').Editor();

            $('#btn-send').click(function(e){
                e.preventDefault();
                $('#tmensaje').text($('#tmensaje').Editor('getText'));
                $('#frm-msg').submit();
            });
        });
    </script>

    <title>Escribir Mensaje</title>
</head>
<body>
    <header>

        <?php include_once '../header.php';?>

    </header>
    <main class="contenedor main">
        <div class="portada">
            <p>aqui va la imagen de portada</p>
        </div>
        
        <div class="servicios">
            <div class="mensajesenviados">
                <div class="titulomen">
                    <h2>Redacta tu Mensaje</h2>
                </div>
                    
                <form action="proceso-msg.php" method="POST" id="frm-msg" enctype="multipart/form-data">
        
                    <div class="parayasunto">
                        <div class="para">
                            <label for="para" class="etiquetatext">PARA: </label> <input type="text" name="tpara" class="text">
                        </div>

                        <div class="asunto">
                            <label for="asunto"class="etiquetatext">Asunto: </label><input type="text" name="tasunto" class="text">
                        </div>
                    </div>

                    <textarea name="tmensaje" id="tmensaje"></textarea>

                    <!-- Create the editor container -->
                    <!-- <div id="editor">
                    <p>Hello World!</p>
                    <p>Some initial <strong>bold</strong> text</p>
                    <p><br></p>

                    </div>  -->
                    <div class="btn">
                        <input class="botonenvio" type="submit" name="enviar" id="btn-send" value="ENVIAR MENSAJE"/>
                    </div>   
                </form>                   
            </div>
        </div>

    </main>   
</body>
<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
  var quill = new Quill('#editor', {
    theme: 'snow'
  });
</script>
</html>