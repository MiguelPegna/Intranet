<!--Consulta Equipo-->
<?php
	## Variables para hacer la conexion al servidor local
	$DB_host='localhost';
	$DB_user='root';
	$DB_pass='';
	$DB_name='intranet';
	#Variablesp para hacer conexion remota
	// $DB_host='sql101.epizy.com';
	// $DB_user='epiz_29280423';
	// $DB_pass='C2aHA9CWp2Sxz';
	// $DB_name='epiz_29280423_intranet';
	//servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos
	$DB_conection = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); 
    if(mysqli_connect_errno()){
        echo'No se pudo hacer la conexion a la DB: ', mysqli_connect_error();
        exit();
    }
	mysqli_query($DB_conection, "SET NAMES 'utf8', lc_time_names = 'es_MX'");
?>


