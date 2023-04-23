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
    $idMsg = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/stock.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Mensaje</title>
</head>
<body>
    <header>

        <?php include_once 'header.php';?>

    </header>

<main class="contenedor main">
        <div class="portada">
            <a href="inbox.php" class="btn btn-warning">REGRESAR AL INBOX</a> / <a href="msg-send.php" class="btn btn-info">MENSAJES ENVIADOS</a> / <a class="btn btn-primary" href="nuevo-msg.php"> + ESCRIBIR NUEVO MENSAJE</a><br/>
        </div>
        <div class="servicios">
            <div class="nuevomensaje">
                
            </div>
            <table class="table table-striped table-bordered table-hover"> 
                <?php
                    if(isset($idMsg)){
                        $sqlMsg="SELECT * FROM mensajes WHERE Id_mensaje='$idMsg'";
                        $mensaje = $DB_conection->query($sqlMsg);
                        $fila = $mensaje -> fetch_array(MYSQLI_BOTH);
                        //Actualizamos el estado de mensaje para que pase a leido
                        $sqlRefresh="UPDATE mensajes SET Leido ='0' WHERE Id_mensaje='$idMsg'";
                        $actualiza = $DB_conection->query($sqlRefresh);

                        #Consulta para mostrar el nombre del usuario que manda el mensaje por medio de su id 
                        $sqlUser="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Sucursal, Departamento, Turno, Foto FROM usuarios WHERE Id_empleado='".$fila['De']."'"; 
                        $encontrar = $DB_conection->query($sqlUser); 
                        $user = $encontrar-> fetch_array(MYSQLI_BOTH);     
                ?>
                <thead> 
                    <tr> 
                        <th><strong>Autor</strong></th>
                        <th><strong>Asunto:</strong> <?php echo $fila['Asunto'];?><br/> <strong> Publicado: </strong><?php echo $fila['Fecha']; ?> </th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <tr>  
                        <td>
                            <strong><?php echo $user['Nombre'].' '. $user['Apellido_p'];?></strong><br/>
                            <a href="user.php?id=<?php echo $user['Id_empleado'] ?>"><img src="<?php echo $user['Foto'];?>" width="150" height="150"></a> <br/>
                            <strong>Dpto: </strong><?php echo $user['Departamento'];?><br/>
                            <strong>Turno: </strong><?php echo $user['Turno'];?><br/>
                            <strong>Suc: </strong><?php echo $user['Sucursal'];?><br/>

                        </td>
                        <td>
                            
                            <!--Imprimimos el mensaje-->
                            <?php echo $fila['Mensaje'];?> <br/>

                            <?php } ?>
                        </td>
                    </tr>
                </tbody> 
                <tfoot> 
                
                </tfoot> 
            </table>
        </div>

    </main>
</body>
</html>