<?php
    #script de validacion de datos para registro de usuarios
    session_start();
    require '../includes/DB_conexion.php';
    require '../includes/funciones.php';
    #require 'includes/posting.php';

    if(!isset($_SESSION['id_usuario'])){
        header('Location: ../index.php');
    }

    $idUser = $_SESSION['id_usuario'];

    $sqlSearch="SELECT * FROM mensajes WHERE Para='$idUser' AND Estado ='Activo 'ORDER BY Id_mensaje desc";
    $resultado = $DB_conection->query($sqlSearch);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/mensajes.css">
    <title>Buzón</title>
</head>
<body>    
    <main class="contenedor main">
        <div class="portada">
            <p>aqui va la imagen de portada</p>
        </div>
        <div class="servicios">
            <div class="nuevomensaje">
                <a href="nuevo.php">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-new-section" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <line x1="9" y1="12" x2="15" y2="12" />
                    <line x1="12" y1="9" x2="12" y2="15" />
                    <path d="M4 6v-1a1 1 0 0 1 1 -1h1m5 0h2m5 0h1a1 1 0 0 1 1 1v1m0 5v2m0 5v1a1 1 0 0 1 -1 1h-1m-5 0h-2m-5 0h-1a1 1 0 0 1 -1 -1v-1m0 -5v-2m0 -5" />
                    </svg>
                    Mensaje Nuevo  
                </a>
            </div>
            <table> 
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
                
                    <?php while($imprimir = $resultado-> fetch_array(MYSQLI_BOTH)) {  
                        #Consulta para mostrar el nombre del usuario que manda el mensaje por medio de su id 
                        $sqlUser="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Sucursal, Departamento, Foto FROM usuarios WHERE Id_empleado='".$imprimir['De']."'"; 
                        $encontrar = $DB_conection->query($sqlUser); 
                        $user = $encontrar-> fetch_array(MYSQLI_BOTH);     
        
                        if($imprimir['Leido'] == 1){ 
                            $leido= "<img src='../img/unread.png' title='No Leido'>";                    
                        } 
                        else { 
                            $leido= "<img src='../img/read.png' title='Leido'>"; 
                        } 
                    ?> 
                        <tr> 
                            <td><?php echo $leido; ?></td> 
                            <td><img src="../<?php echo $user['Foto']; ?>" title="<?php echo $user['Nombre']; ?>" width="50" height="50"/></td> 
                            <td><?php echo $user['Nombre'] .' '. $user['Apellido_p']; ?> <br/><?php echo $user['Departamento']; ?></td> 
                            <td><a href="mensaje.php?id=<?php echo $imprimir['Id_mensaje']; ?>"><?php echo $imprimir['Asunto']; ?> </a></td> 
                            <td><?php echo $imprimir['Fecha']; ?></td> 
                            <td><a href="borrar.php?id=<?php echo $imprimir['Id_mensaje']; ?>"><img src="../img/trash.png" title="Enviar a papelera" width="25" heigth="25"></a></td> 
                        </tr> 
                    <?php } ?> 
                </tbody> 
                <tfoot> 
                    <tr> 
                        <td>Total</td> 
                        <td class="tdTotal"> </td> 
                    </tr> 
                </tfoot> 
            </table>
        </div>

    </main>
</body>
</html>