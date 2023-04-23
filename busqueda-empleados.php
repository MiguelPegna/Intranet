
<?php
    #script de validacion de datos para registro de usuarios
    session_start();
    require 'includes/DB_conexion.php';
    require 'includes/funciones.php';

    if(!isset($_SESSION['id_usuario'])){
        header('Location: index.php');
    }

    $idUser = $_SESSION['id_usuario'];
    $accesos= $_SESSION['permisos'];


    if($accesos==3 or $accesos==4){
        header('Location: index.php');
    }
    #Consulta info de proveedor
    $resultado='';
    $query = "SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Fecha_nac, RFC, Sexo, Calle, Colonia, CP, Entidad, Telefono, Sucursal, Turno, Departamento, Email FROM usuarios WHERE Cuenta=1 ORDER BY Apellido_p ASC";
    
    if(isset($_POST['consulta'])){
        $txt=$DB_conection->real_escape_string($_POST['consulta']);
        $query = "SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Fecha_nac, RFC, Sexo, Calle, Colonia, CP, Entidad, Telefono, Sucursal, Turno, Departamento, Email 
        FROM usuarios 
        WHERE Cuenta=1 AND Nombre LIKE '%".$txt."%' OR Apellido_p LIKE '%".$txt."%' OR Apellido_m LIKE '%".$txt."%' OR Sexo LIKE '%".$txt."%' OR Turno LIKE '%".$txt."%' OR Sucursal LIKE '%".$txt."%' Or Departamento LIKE '%".$txt."%' OR Email LIKE '%".$txt."%' ORDER BY Id_empleado";
    }
    $infoQuery=$DB_conection->query($query);

    if($infoQuery->num_rows > 0){
        $resultado.="
            <table class='table table-sm table-hover'>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre Empleado</th>
                            <th>Fecha Nac.</th>
                            <th>Dirección</th>
                            <th>Info Contacto</th>
                            <th>Info Trabajo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
                    $i=0;
                    while($usuario =$infoQuery->fetch_assoc()){
                        $i++;
                        $resultado.="
                            <tr>
                                <td> $i</td>
                                <td>".$usuario['Apellido_p']." ".$usuario['Apellido_m']." ".$usuario['Nombre']." <br/> ".$usuario['Sexo']." </td>
                                <td>".$usuario['Fecha_nac']."<br/> RFC: ".$usuario['RFC']."
                                <td>".$usuario['Calle']." Col: ".$usuario['Colonia']."<br/> C.P ".$usuario['CP'].", ".$usuario['Entidad']."</td>
                                <td>Tel: ".$usuario['Telefono']." <br/> ".$usuario['Email']." </td>
                                <td>Suc: ".$usuario['Sucursal']." <br/>Turno: ".$usuario['Turno']." <br/>Depto: ".$usuario['Departamento']." </td>
                                <td><a href='edit-empleado.php?id=".$usuario['Id_empleado']."' class='btn btn-outline-secondary btn-lg btn-block'>Editar</a></td>
                            </tr>
                        ";
                    }
                    $resultado.="</tbody> </table>";
    }
    else{
        $resultado.="No se han encontrado registros relacionados a tu busqueda :( ";

    }
    echo $resultado;

?>