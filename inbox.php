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

    $sqlChat="SELECT * FROM mensajes WHERE Para='$idUser' AND Estado ='Activo' ORDER BY Id_mensaje desc";
    $chat = $DB_conection->query($sqlChat);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/Inicio.css">
    <link rel="stylesheet" href="css/stock.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>Buzón</title>
</head>
<body>
    <header>

        <?php include_once 'header.php';?>

    </header>

<main class="contenedor main">
        <div class="portada">
            <a href="msg-send.php" class="btn btn-info">MENSAJES ENVIADOS</a> / <a class="btn btn-primary" href="nuevo-msg.php"> + ESCRIBIR NUEVO MENSAJE</a><br/>
        </div>
        <div class="servicios">
            <div class="nuevomensaje">
                <h2><?php echo $imprimir['Nombre'];?> estos son los mensajes que has recibido. </h2>
            </div>
            <table class="table table-sm table-hover table-bordered"> 
                <thead> 
                    <tr> 
                        <th></th> 
                        <th></th> 
                        <th>De</th> 
                        <th>Asunto</th> 
                        <th>Fecha</th> 
                        <th>Borrar</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <!-- seccion del while -->  
                
                    <?php while($verChat = $chat-> fetch_array(MYSQLI_BOTH)) {  
                        #Consulta para mostrar el nombre del usuario que manda el mensaje por medio de su id 
                        $sqlUser="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Sucursal, Departamento, Foto FROM usuarios WHERE Id_empleado='".$verChat['De']."'"; 
                        $encontrar = $DB_conection->query($sqlUser); 
                        $user = $encontrar-> fetch_array(MYSQLI_BOTH);     
        
                        if($verChat['Leido'] == 1){ 
                            $leido= "<img src='img/unread.png' title='No Leido'>";                    
                        } 
                        else { 
                            $leido= "<img src='img/read.png' title='Leido'>"; 
                        } 
                    ?> 
                        <tr> 
                            <td><?php echo $leido; ?></td> 
                            <td><a href="user.php?id=<?php echo $user['Id_empleado'] ?>"><img src="<?php echo $user['Foto']; ?>" title="<?php echo $user['Nombre']; ?>" width="50" height="50"/></a></td> 
                            <td><?php echo $user['Nombre'] .' '. $user['Apellido_p']; ?> <br/><?php echo $user['Departamento']; ?></td> 
                            <td><a href="mensaje.php?id=<?php echo $verChat['Id_mensaje']; ?>" class="btn btn-outline-secondary btn-lg btn-block"><?php echo $verChat['Asunto']; ?> </a></td> 
                            <td><?php echo $verChat['Fecha']; ?></td> 
                            <td><a href="borrar-msg.php?id=<?php echo $verChat['Id_mensaje']; ?>"><img src="img/trash.png" title="Enviar a papelera" width="25" heigth="25"></a></td> 
                        </tr> 
                    <?php } ?> 
                </tbody> 
                <tfoot> 
                
                </tfoot> 
            </table>
        </div>
        <?php include_once 'footer.html';?>
    </main>
</body>
</html>