<?php
    #script de validacion de datos para envio de mensajes
    session_start();
    require 'includes/DB_conexion.php';
    require 'includes/mensajeria.php';
    $errores = array();
    $idUser = $_SESSION['id_usuario'];
    $accesos= $_SESSION['permisos'];

    if(!isset($idUser)){
        header('Location: index.php');
    }

     //Consulta para poder visualizar los nombres en el input
	$sqlSearch="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Departamento, Sucursal, Turno FROM usuarios WHERE Cuenta=1 ORDER BY Apellido_p ASC";
	$mostrar = $DB_conection->query($sqlSearch);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/Inicio.css">
    <link rel="stylesheet" href="css/stock.css">

    <script src="js/jquery-1.12.0.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="js/editor.js"></script>
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <link rel="stylesheet" href="css/editor.css">
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

        <?php include_once 'header2.php';?>

    </header>
    <main class="contenedor main">
        <div class="portada">
            <a href="inbox.php" class="btn btn-warning">REGRESAR AL INBOX</a> / <a href="msg-send.php" class="btn btn-info">MENSAJES ENVIADOS</a> <br/>
        </div>
        
        <div class="servicios">
            <div class="mensajesenviados">
                <div class="titulomen">
                    <h2>Redacta tu Mensaje</h2>
                </div>
                    
                <form action="proceso-msg.php" method="POST" id="frm-msg" enctype="multipart/form-data">
        
                    <div class="parayasunto">
                        <div class="para">
                            <label for="para" class="etiquetatext"><h4><strong>PARA: </h4></strong></label> &nbsp;
                            <!-- <input type="text" name="tpara" class="text"> -->
                            <select name="tpara" data-placeholder="Enviar a...">
                                <option value="No Existe">Enviar a...</option>
                                <?php while($registro = $mostrar-> fetch_array(MYSQLI_BOTH)){ ?>
                                    <option value="<?php echo $registro['Nombre'] ?>"><?php echo $registro['Apellido_p'].' '. $registro['Apellido_m'].' '. $registro['Nombre'].' || Depto: '. $registro['Departamento'].' || Suc:'. $registro['Sucursal']. ' || Turno: '. $registro['Turno'] ; ?> </option>
                                <?php } ?>
                                
                            </select>
                        </div>

                        <div class="asunto">
                            <label for="asunto"class="etiquetatext"><h4><strong>Asunto: </h4></strong></label> &nbsp; <input type="text" name="tasunto" class="text" size="35">
                        </div>
                    </div>

                    <textarea name="tmensaje" id="tmensaje"></textarea>

                   
                    <div class="btn">
                        <input class="btn btn-success" type="submit" name="enviar" id="btn-send" value="ENVIAR MENSAJE"/>
                    </div>   
                </form>                   
            </div>
        </div>
        <?php include_once 'footer.html';?>
    </main>   
</body>

</html>