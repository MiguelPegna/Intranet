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
    <title>Buzón</title>
</head>
<body>
    <a href="nuevo.php">+ Mensaje Nuevo</a></br>
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
                    <td><img src="<?php echo $user['Foto']; ?>" title="<?php echo $user['Nombre']; ?>" width="50" height="50"/></td>
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
    
</body>
</html>