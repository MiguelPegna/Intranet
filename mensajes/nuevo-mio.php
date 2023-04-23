<?php
    #script de validacion de datos para envio de mensajes
    session_start();
    require '../includes/DB_conexion.php';
    require '../includes/mensajeria.php';
    #require 'includes/posting.php';

    $errores = array();
    $idUser = $_SESSION['id_usuario'];

    if(!isset($idUser)){
        header('Location: ../index.php');
    }

//Consulta para poder visualizar los nombres en el input
$sqlSearch="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Departamento, Sucursal, Turno FROM usuarios";
$mostrar = $DB_conection->query($sqlSearch);

$arreglo=array();
if($mostrar){
    while($registro = $mostrar-> fetch_array(MYSQLI_BOTH)) {       
        $trabajador= ''. $registro['Nombre'].' '. $registro['Apellido_p'].' '. $registro['Apellido_m'].' || '. $registro['Departamento'].' || Suc: '. $registro['Sucursal'].' || Turno: '. $registro['Turno'].'';
        array_push($arreglo, $trabajador); //Array con los trabajadore y su info
    }

    if(!empty($_POST)){
    $varPara = $DB_conection->real_escape_string($_POST['tpara']);
    $varAsunto = $DB_conection->real_escape_string($_POST['tasunto']);
    $varMensaje = $DB_conection->real_escape_string($_POST['tmensaje']);

    
    if(revCampos($varPara, $varAsunto, $varMensaje)){
        $errores[] ="Llena TODOS los campos";
    }

    if(!encontrarUsuario($varPara)){
        $errores[] ="El usuario a quien quieres mandar mensaje no existe en la base de datos";
    }


    if(count($errores)==0){
        echo var_dump($cambio);
        echo var_dump($trabajador);
        // if(enviarMensaje($idUser, $cambio, $varAsunto, $varMensaje)){
        //     echo'Se ha mandado el mensaje correctamente a: ' .$varPara . '<br/>';
        //     echo"<a href='index.php'>Regresar a Buzón</a>";
        //     exit; 
        // }
        // else{
        //     $errores[]="Error al enviar mensaje";
        // }
    }
} 
}
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="jquery/jquery-1.12.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="jquery/jquery-ui.css">
	<script type="text/javascript" src="jquery/jquery-ui.js"></script>
    <title>Escribir Mensaje</title>
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    
        <label for="para">PARA: </label> 
        <input type="text" name="tpara" id="tag" size="50"><br/>

        <label for="asunto">Asunto: </label>
        <input type="text" name="tasunto"><br/>

        <textarea cols="150" rows="15" name="tmensaje"></textarea></br>
        <input type="submit" name="enviar" value="ENVIAR MENSAJE"/>
        
    </form>
    <div class="error">
        <?php
            echo listaErrores($errores);
        ?>
    </div>
    <script type="text/javascript">
		$(document).ready(function () {
			let items = <?= json_encode($arreglo) ?>

			$("#tag").autocomplete({
				source: items,
                select: function(event, item){
                    console.log(item.item.value);
                    // let param = {
                    //     usuario: item.item.value
                    // };
                    // $.get('getNombre.php', param, function(respuesta){
                    //     console.log(respuesta);
                    // });
                }
				
			});
		});
	</script>
    
</body>
</html>