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

    if($accesos==2 or $accesos==3 or $accesos==4){
        header('Location: index.php');
    }

    $errores = array();
    if(!empty($_POST)){
        $varNombre= $DB_conection->real_escape_string(ucwords($_POST['tnombre']));
        $varRepresentante= $DB_conection->real_escape_string(ucwords($_POST['trepresentante']));
        $varTel = $DB_conection->real_escape_string($_POST['ttel']);
        $varDireccion = $DB_conection->real_escape_string(ucwords($_POST['tdir']));
        $varMail = $DB_conection->real_escape_string($_POST['tmail']);
        $varRFC = $DB_conection->real_escape_string(strtoupper($_POST['trfc']));
        $_FILES['tfoto'];

        if(checarCliente($varNombre, $varRepresentante, $varTel, $varDireccion, $varMail, $varRFC)){
            $errores[] ="Llena TODOS los campos";
        }
        if(!esMail($varMail)){
            $errores[] ="El E-mail no es valido";
        }

        if(count($errores)==0){
            if($_FILES['tfoto']['error']>0 ){
                $varRuta='img/cliente.jpg';
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
                        echo "<script>alert('El nombre de la imagen que quieres asignar al cliente ya existe'); </script>";
                        echo "<script>setTimeout(\"location.href='add-cliente.php'\",500); </script>";
                    }
                }
                else{
                    echo "<script>alert('Extensión de archivo no permitida o excede 5Mb'); </script>";
                    echo "<script>setTimeout(\"location.href='add-cliente.php'\",500); </script>";
                }
            }
            addCliente($varNombre, $varRepresentante, $varTel, $varDireccion, $varMail, $varRFC, $varRuta);
            echo "<script>alert('¡El nuevo cliente se ha agregado correctamente a la DB :)!'); </script>";
            echo "<script>setTimeout(\"location.href='clientes.php'\",500); </script>";         
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

    <title> .:Agregar Cliente:. </title>
</head>
<body>
    <header>

        <?php include_once 'header2.php';?>

    </header>
    <main class="contenedor main">
        <div class="portada">
            <a href="clientes.php" class="btn btn-warning">VOLVER A LISTA DE CLIENTES</a><br/>
            <div class="error">
                <?php
                    echo listaErrores($errores);
                ?>
            </div>  
        </div>
        <div class="servicios">
            <h2>Agregar un nuevo producto</h2>

            <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                <div class="servicios2">
                    <div class="tabla">
                        <fieldset>
                            <legend><strong>Información del cliente</strong></legend>
                            <div class="celda">
                                <label for="nombre">Empresa</label>
                                <input type="text" name="tnombre" />  
                            </div>

                            <div class="celda">
                                <label for="representante">Representante</label>
                                <input type="text" name="trepresentante" />
                            </div>

                            <div class="celda">
                                <label for="telefono">Teléfono</label>
                                <input type="text" name="ttel" />
                            </div>

                            <div class="celda">
                                <label for="direccion">Dirección</label>
                                <input type="text" name="tdir" />
                            </div>

                            <div class="celda">
                                <label for="mail">EMail</label>
                                <input type="text" name="tmail" />
                            </div>
                                
                            <div class="celda">
                                <label for="rfc">RFC</label>
                                <input type="text" name="trfc" />
                            </div>

                        </fieldset>

                        

                            
                        <h2><input type="submit" class="btn btn-success" value="GUARDAR CLIENTE"/></h2>
                        
                    </div>

                    <div class="aside">                   
                        <div class="usuariosOnline caja-aside">
                            <h2>
                                <label class="etiqueta" for="Foto">Selecciona una foto para el cliente</label>
                                <br/><br/>
                                
                                <input type="file" name="tfoto" class="btn btn-primary"/></br><br/>

                            </h2>
                        </div>
                    </div>
                </div>
            </form>
        </div> 
        <?php include_once 'footer.html';?>
    </main>
</body>
</html>