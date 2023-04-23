<?php 
	session_start();
	require '../includes/DB_conexion.php';
	require '../includes/mensajeria.php';
	#require 'includes/posting.php';

	$idUser = $_SESSION['id_usuario'];

	if(!isset($idUser)){
		header('Location: ../index.php');
	}
	$nombreUser = $_GET['usuario'];
	$sqlSearch="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Departamento, Sucursal, Turno FROM usuarios LIMIT 1";
	$mostrar = $DB_conection->query($sqlSearch);

	if ($mostrar){
		$registro = $mostrar->fetch_object();
		$registro->status = 200;
		echo json_encode($registro);
	}
	else{
		$error= array('status'=> 400);
		echo json_encode((object)$error);
	}

	// if($resultado){
	// 	while($imprimir = $resultado-> fetch_array(MYSQLI_BOTH)) { 
	// 		$html= '<img src="../'.$imprimir['Foto'].'"  width="20" height="20" border="1">  
	// 				'. $imprimir['Nombre'].' 
	// 				'. $imprimir['Apellido_p'].'
	// 				'. $imprimir['Apellido_m'].'
	// 				'. $imprimir['Departamento'].'
	// 				Suc:'. $imprimir['Sucursal'].'					
	// 				<br/>
	// 				';
	// 		echo $html;
	// 	}
	// }