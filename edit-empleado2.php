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
    $idUsuario = $_GET['id'];

    if($accesos==3 or $accesos==4){
        header('Location: index.php');
    }

    #Consulta info de empleado
    $sqlEmpleado="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Fecha_nac, RFC, Sexo, Calle, Colonia, CP, Entidad, Telefono, Sucursal, Turno, Departamento, Email, Permisos, Foto FROM usuarios WHERE Id_empleado=$idUsuario AND Cuenta=1 LIMIT 1";
    $infoEmpleado = $DB_conection->query($sqlEmpleado);
    $empleado = $infoEmpleado->fetch_assoc();

    $errores = array();
    if(!empty($_POST)){
        $varNombre= $DB_conection->real_escape_string(ucwords($_POST['tnombre']));
        $varApellido1= $DB_conection->real_escape_string(ucwords($_POST['tap1']));
        $varApellido2= $DB_conection->real_escape_string(ucwords($_POST['tap2']));
        $varNac= $DB_conection->real_escape_string($_POST['tfecha']);
        $varRFC = $DB_conection->real_escape_string(strtoupper($_POST['trfc']));
        $varSexo= $DB_conection->real_escape_string(ucwords($_POST['tsexo']));
        $varCalle= $DB_conection->real_escape_string(ucwords($_POST['tcalle']));
        $varCol= $DB_conection->real_escape_string(ucwords($_POST['tcol']));
        $varCP = $DB_conection->real_escape_string($_POST['tcp']);
        $varEntidad= $DB_conection->real_escape_string(ucwords($_POST['tentidad']));
        $varTel = $DB_conection->real_escape_string($_POST['ttel']);
        $varSuc= $DB_conection->real_escape_string(ucwords($_POST['tsuc']));
        $varTurno= $DB_conection->real_escape_string(ucwords($_POST['tturno']));
        $varDepto= $DB_conection->real_escape_string(ucwords($_POST['tdepto']));
        $varMail = $DB_conection->real_escape_string($_POST['tmail']);
        $varPermisos = $DB_conection->real_escape_string($_POST['tpermisos']);

        $_FILES['tfoto'];

        if(checarEmpleado($varNombre, $varApellido1, $varApellido2, $varNac, $varRFC, $varSexo, $varCalle, $varCol, $varCP, $varEntidad, $varTel, $varSuc, $varTurno, $varDepto, $varMail, $varPermisos)){
            $errores[] ="Llena TODOS los campos";
        }

        if(count($errores)==0){
            if($_FILES['tfoto']['error']>0 ){
                $varRuta=$empleado['Foto'];
            }
            else {
                $varExtension = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
                $varKb=500;
                $varSize= $varKb *1024;  #pasamos el valor de la varKb a KB
                #Se verifica que el archivo que se esta subiendo tiene extensión aceptada y no sobrepasa el tamaño definido 
                if(in_array($_FILES['tfoto']['type'], $varExtension) && $_FILES['tfoto']['size']<= $varSize){
                    $varDir='img/';
                    $varRuta= $varDir.$_FILES['tfoto']['name'];
                    #Si no existe el directorio lo crea
                    if(!file_exists($varDir)){
                        mkdir($varDir);
                    }
                    #If para evitar archivos duplicados
                    if(!file_exists($varRuta)){
                        $varFoto= @move_uploaded_file($_FILES['tfoto']['tmp_name'], $varRuta);       
                    }
                    else{
                        echo "<script>alert('El nombre de la imagen que quieres asignar al producto ya existe'); </script>";
                        echo "<script>setTimeout(\"location.href='edit-producto.php'\",500); </script>";
                    }
                }
                else{
                    echo "<script>alert('Extensión de archivo no permitida o excede 5Mb'); </script>";
                    echo "<script>setTimeout(\"location.href='edit-producto.php'\",500); </script>";
                }
            }
            editUser($varNombre, $varApellido1, $varApellido2, $varNac, $varRFC, $varSexo, $varCalle, $varCol, $varCP, $varEntidad, $varTel, $varSuc, $varTurno, $varDepto, $varMail, $varPermisos, $varRuta, $idUsuario);
            echo "<script>alert('¡La info del usuario se ha actualizado correctamente :)!'); </script>";
            echo "<script>setTimeout(\"location.href='lista-usuarios.php'\",500); </script>";         
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stock.css">
    <link rel="stylesheet" href="css/buzon.css">

    <script src="https://kit.fontawesome.com/88d10ff1ee.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="css/modalBorrar.css"> 
    <script type='text/javascript' src='js/modalBorrar.js'></script>    
    

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">

    <title> <?php echo $empleado['Apellido_p'] .' '. $empleado['Apellido_m'] .' '. $empleado['Nombre']; ?> +
</title>
</head>
<body>
    <header>

        <?php include_once 'header2.php';?>

    </header>
    <main class="contenedor main">
        <div class="portada">
            <p>aqui va la imagen de portada</p>
        </div>
        <div class="servicios">
            <h2>Modificar Informacion del usuario: <?php echo $empleado['Apellido_p'] .' '. $empleado['Apellido_m'] .' '. $empleado['Nombre']; ?></h2>

            <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">

                <label for="nombre">Nombre(s) </label>
                <input type="text" name="tnombre" value="<?php echo $empleado['Nombre']; ?>"/><br/>

                <label for="apellidoP">Apellido Paterno</label>
                <input type="text" name="tap1" value="<?php echo $empleado['Apellido_p']; ?>"/><br/>

                <label for="apellidoM">Apellido materno</label>
                <input type="text" name="tap2" value="<?php echo $empleado['Apellido_m']; ?>"/><br/>

                <label for="fecha">Fecha Nac:</label>
                <input type="date" name="tfecha" value="<?php echo $empleado['Fecha_nac']; ?>"/><br/>

                <label for="rfc">RFC</label>
                <input type="text" name="trfc" value="<?php echo $empleado['RFC']; ?>"/><br/>

                <label for="sexo">Sexo</label>
                <select name="tsexo">
                    <option value="<?php echo $empleado['Sexo']; ?>"><?php echo $empleado['Sexo']; ?></option>
                    <option value="<?php echo $empleado['Sexo']; ?>">------</option>
                    <option value="Femenino">FEMENINO</option>
                    <option value="Masculino">MASCULINO</option>
                
                </select><br/>

                <label for="calle">Calle: </label>
                <input type="text" name="tcalle" value="<?php echo $empleado['Calle']; ?>"/><br/>
                
                <label for="colonia">Colonia</label>
                <input type="text" name="tcol" value="<?php echo $empleado['Colonia']; ?>"/><br/>

                <label for="cp">CP</label>
                <input type="text" name="tcp" value="<?php echo $empleado['CP']; ?>"/><br/>

                <label for="entidad">Entidad</label>
                <input type="text" name="tentidad" value="<?php echo $empleado['Entidad']; ?>"/><br/>

                <label for="telefono">Teléfono</label>
                <input type="text" name="ttel" value="<?php echo $empleado['Telefono']; ?>"/><br/>

                <label for="sucursal">Sucursal</label>
                <select name="tsuc">
                    <option value="<?php echo $empleado['Sucursal']; ?>"><?php echo $empleado['Sucursal']; ?></option>
                    <option value="<?php echo $empleado['Sucursal']; ?>">------</option>
                    <option value="Centro">CENTRO</option>
                    <option value="Norte">NORTE</option>  
                    <option value="Sur">SUR</option>       
                </select><br/>

                <label for="turno">Turno</label>
                <select name="tturno">
                    <option value="<?php echo $empleado['Turno']; ?>"><?php echo $empleado['Turno']; ?></option>
                    <option value="<?php echo $empleado['Turno']; ?>">------</option>
                    <option value="Matutino">MATUTINO</option>
                    <option value="Vespertino">VESPERTINO</option>
                
                </select><br/>

                <label for="depto">Departamento</label>
                <select name="tdepto">
                    <option value="<?php echo $empleado['Departamento']; ?>"><?php echo $empleado['Departamento']; ?></option>
                    <option value="<?php echo $empleado['Departamento']; ?>">------</option>
                    <option value="Dirección General">DIRECCIÓN GENERAL</option>
                    <option value="Recursos Humanos">RECURSOS HUMANOS</option>
                    <option value="Sistemas">SISTEMAS</option>
                    <option value="Finanzas">FINANZAS</option>
                    <option value="Almacén">ALMACÉN</option>               
                </select><br/>

                <label for="permisos">Nivel de Permisos</label>
                <select name="tpermisos">
                    <option value="<?php echo $empleado['Permisos']; ?>"> 
                        <?php $rol=''; if ($empleado['Permisos']==1){$rol='1- Dirección General';}
                                        else if ($empleado['Permisos']==2){$rol='2- Administrativo';}
                                        else if ($empleado['Permisos']==3){$rol='3- Gerente de Depto';}
                                        else if ($empleado['Permisos']==4){$rol='4- Usuario';}
                                        echo $rol; ?></option>
                    <option value="<?php echo $empleado['Permisos']; ?>">------</option>
                    <option value="1">1- DIRECCIÓN GENERAL</option>
                    <option value="2">2- ADMINISTRATIVO</option>
                    <option value="3">3- GERENTE DE DEPTO</option>
                    <option value="4">4 -USUARIO</option>              
                </select><br/>

                <label for="email">Email</label>
                <input type="text" name="tmail" value="<?php echo $empleado['Email']; ?>"/><br/>
                
                <label for="Foto">Foto</label>
                <div><img src="<?php echo $empleado['Foto']; ?>" width="100" height="150"></div>
                <input type="file" name="tfoto" /><br/>
                

                <input type="submit" value="GUARDAR"/>

                <a href="javascript:boton1();" class="btnborrar">Borrar</a>

            </form>
            <div class="error">
                <?php
                    echo listaErrores($errores);
                ?>
            </div>  
        </div> 
    </main>

     

<!--modal-->
<div class="modal" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-title"><h2>Borrar</h2></div>
            <i class="far fa-times-circle" id="close"></i>
            <div class="modal-body"> 
                <p>¿Estás seguro de querer borrar a este empleado de la lista?</p>
                <div class="botones">
                    <a href="#" class="btn-red close" >CANCELAR</a>
                    <a href="borrar-producto.php?id=<?php echo $empleado['Id_empleado'];?>" class="btn-green" >ACEPTAR</a>
                </div>
            </div> 
            <div class="modal-title"></div>
        </div>
    </div>  
</div>

</body>
</html>