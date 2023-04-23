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

    #Consulta de configuracion
    $sqlConfig="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Foto, Pass FROM usuarios WHERE Id_empleado=$idUser";
    $configuracion = $DB_conection->query($sqlConfig);
    $verConfig = $configuracion->fetch_assoc();

    $errores = array();
    //Se comprueba la informacion de los campos para su envio y actualizacion
    if(!empty($_POST)){
        $varPass01 = $DB_conection->real_escape_string($_POST['t1']);
        $varPass02 = $DB_conection ->real_escape_string($_POST['t2']);
        $varPass03 = $DB_conection ->real_escape_string($_POST['t3']);
      
        if(checkInputPass($varPass01, $varPass02, $varPass03)){
            $errores[] = 'Debes llenar todos los campos';
        }

        if(!validarPass($varPass01, $varPass02)){
            $errores[] ='Las contraseñas no son iguales, pinche manco';
        }

        if(count($errores)==0){
            checkPassActual($idUser, $varPass03);
            $newPass= passSeguro($varPass01);
            refreshPass($newPass, $idUser);
            echo "<script>alert('¡Haz cambiado tu contraseña con éxito :)!'); </script>";
            }
            else{
                $errores[] ='La contraseña actual no coincide con la de la DB';
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
    <link rel="stylesheet" href="css/stock.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-RXf+QSDCUQs5uwRKaDoXt55jygZZm2V++WUZduaU/Ui/9EGp3f/2KZVahFZBKGH0s774sd3HmrhUy+SgOFQLVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    

    <script type="text/javascript" src="js/validaPass.js"></script>
    <title>Configuración</title>
</head>
<body>
    <header>

        <?php include_once 'header.php';?>

    </header>
    
    <main class="contenedor main">
        <div class="portada">
            
        </div>
        <div class="servicios">
            <h2>Configuración de cuenta</h2>
            <div class="doscolumnas">
            
                <div class="usuario">
                    <form method="post" action="uploadAvatar.php" name="foto" enctype="multipart/form-data">
                        <input type="file" name="imagen" class="boton"  /><br/>
                        <img src="<?php echo $verConfig['Foto']?>" width="250" height="250" style="border-radius:50%">   <br/>                    
                        <button class="boton btnborrar btn btn-primary">CAMBIAR FOTO</button><br/>                       
                    </form>
                </div>
                
                <div class="inf-emp">
                        <div class="inf">
                            <h3>Para gestionar otro tipo de cambios ponerse en contacto con personal de Recursos Humanos</h3>
                            <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                            <table>
                                <tr>
                                    <th></th>
                                    <th>Cambiar contraseña
                                </tr>

                                <tr>
                                    <td>Nueva contraseña</td>
                                    <td><input type="password" name="t1" id="ver01"> <a href="javascript:verPass01();" title="Mostrar Contraseña"><i class="fa fa-eye" aria-hidden="true" ></i></a></td>
                                </tr>

                                <tr>
                                    <td>Repetir nueva contraseña</td>
                                    <td><input type="password" name="t2" id="ver02"> <a href="javascript:verPass02();" title="Mostrar Contraseña"><i class="fa fa-eye" aria-hidden="true" ></i></a></td>
                                </tr>

                                <tr>
                                    <td> </td>
                                    <td>Para cambiar contraseña escribe tu contraseña actual</td>
                                </tr>

                                <tr>
                                    <td>Contraseña actual</td>
                                    <td><input type="password" name="t3" id="ver03">  <a href="javascript:verPass03();" title="Mostrar Contraseña"><i class="fa fa-eye" aria-hidden="true" ></i></a></td>
                                </tr>

                                <tr>
                                    <td> </td>
                                    <td><input type="submit" name="boton btnborrar btn btn-primary" value="GUARDAR CAMBIOS"></td>
                                </tr>

                                <tr>
                                    <td> </td>
                                    <td>
                                        <div class="error">
                                            <?php
                                                echo listaErrores($errores);
                                            ?>
                                        </div>
                                    </td>
                                </tr>

                            </table> 
                        </div>                        
                </div>

            </div><!--dos columnas-->
                
        </div>
        <?php include_once 'footer.html';?>
    </main>
    
</body>
</html>