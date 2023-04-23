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
    $idProveedor = $_GET['id'];

    if($accesos==2 or $accesos==3 or $accesos==4){
        header('Location: index.php');
    }
    #Consulta info de proveedor
    $sqlProveedor="SELECT * FROM proveedores WHERE Id_proveedor=$idProveedor AND Estado=1 LIMIT 1";
    $infoProveedor = $DB_conection->query($sqlProveedor);
    $proveedor = $infoProveedor->fetch_assoc();

    $errores = array();
    if(!empty($_POST)){
        $varNombre= $DB_conection->real_escape_string(ucwords($_POST['tnombre']));
        $varTel = $DB_conection->real_escape_string($_POST['ttel']);      
        $varDireccion = $DB_conection->real_escape_string(ucwords($_POST['tdir']));
        $varCP = $DB_conection->real_escape_string($_POST['tcp']);
        $varRFC = $DB_conection->real_escape_string(strtoupper($_POST['trfc']));
        $varMail = $DB_conection->real_escape_string($_POST['tmail']);
        $_FILES['tfoto'];

        if(checarProveedor($varNombre, $varTel, $varDireccion, $varCP, $varRFC, $varMail)){
            $errores[] ="Llena TODOS los campos";
        }
        if(!esMail($varMail)){
            $errores[] ="El E-mail no es valido";
        }
        if(count($errores)==0){
            if($_FILES['tfoto']['error']>0 ){
                $varRuta=$proveedor['Foto'];
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
                        echo "<script>alert('El nombre de la imagen que quieres asignar al proveedor ya existe'); </script>";
                        echo "<script>setTimeout(\"location.href='add-proveedor.php'\",500); </script>";
                    }
                }
                else{
                    echo "<script>alert('Extensión de archivo no permitida o excede 5Mb'); </script>";
                    echo "<script>setTimeout(\"location.href='add-proveedor.php'\",500); </script>";
                }
            }
            editProveedor($varNombre, $varTel, $varDireccion, $varCP, $varRFC, $varRuta, $varMail, $idProveedor);
            echo "<script>alert('¡El nuevo proveedor se ha agregado correctamente a la DB :)!'); </script>";
            echo "<script>setTimeout(\"location.href='proveedores.php'\",500); </script>";         
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Inicio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="https://kit.fontawesome.com/88d10ff1ee.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="css/modalBorrar.css"> 
    <script type='text/javascript' src='js/modalBorrar.js'></script>    
    

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        .tabla{
            background-color: rgb(195, 195,195);
            font-size: 1.5rem;
            border-radius: 10px;
            padding: 15px;
        }

        .letra{
            color: #fff;
        }
        .celda{
            display: inline-block;
            margin: 15px;
        }
        fieldset{
            margin-bottom: 5px;
        }
        
    </style>

    <title><?php echo $proveedor['Nombre_empresa']; ?> </title>
</head>
<body>
    <header>

        <?php include_once 'header2.php';?>

    </header>
    <main class="contenedor main">
        <div class="portada">
            <a href="proveedores.php" class="btn btn-warning">VOLVER A LISTA DE PROVEEDORES</a> / <a class="btn btn-primary" href="add-proveedor.php"> + AGREGAR NUEVO PROVEEDOR</a><br/>
            <div class="error">
                <?php
                    echo listaErrores($errores);
                ?>
            </div>  
        </div>
        <div class="servicios">
            <h2>Modificar información del proveedor: <?php echo $proveedor['Nombre_empresa']; ?> </h2>
            <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                <div class="servicios2">
                    <div class="tabla">
                        <fieldset>
                            <legend><strong>Información del proveedor</strong></legend>
                            <div class="celda">
                                <label for="nombre">Empresa</label>
                                <input type="text" name="tnombre" value="<?php echo $proveedor['Nombre_empresa']; ?>"/>  
                            </div>

                            <div class="celda">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="ttel" value="<?php echo $proveedor['Telefono']; ?>"/>
                            </div>

                            <div class="celda">
                                <label for="direccion">Dirección</label>
                                <input type="text" name="tdir" value="<?php echo $proveedor['Direccion']; ?>"/>
                            </div>

                            <div class="celda">
                                <label for="cp">CP</label>
                                <input type="number" name="tcp" value="<?php echo $proveedor['CP']; ?>"/>
                            </div>

                            <div class="celda">
                                <label for="rfc">RFC</label>
                                <input type="text" name="trfc" value="<?php echo $proveedor['RFC']; ?>"/>
                            </div>

                            <div class="celda">
                                <label for="mail">EMail</label>
                                <input type="text" name="tmail" value="<?php echo $proveedor['Email']; ?>"/>
                            </div>
                                

                        </fieldset>   
                         
                        <h2><input type="submit" class="btn btn-success" value="GUARDAR CAMBIOS"/></h2>
                        
                    </div>

                    <div class="aside">                   
                        <div class="usuariosOnline caja-aside">
                        <h2>
                                <label class="etiqueta" for="Foto">Foto del producto</label>
                                <div><img src="<?php echo $proveedor['Foto']; ?>" width="210" height="210"></div>
                                <input type="file" name="tfoto" class="btn btn-primary"/></br><br/>
                                <a href="javascript:boton1();" class="btn btn-danger">BORRAR PRODUCTO</a>
                            </h2>
                        </div>
                    </div>
                </div>
            </form>
        </div> 
        <?php include_once 'footer.html';?>
    </main>
<!--modal-->
<div class="modal" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-title"><h2>Borrar</h2></div>
            <i class="far fa-times-circle" id="close"></i>
            <div class="modal-body"> 
                <p>¿Estás seguro de querer borrar este proveedor de la lista?</p>
                <div class="botones">
                    <a href="#" class="btn-red close" >CANCELAR</a>
                    <a href="borrar-proveedor.php?id=<?php echo $proveedor['Id_proveedor'];?>" class="btn-green" >ACEPTAR</a>
                </div>
            </div> 
            <div class="modal-title"></div>
        </div>
    </div>  
</div>
</body>
</html>