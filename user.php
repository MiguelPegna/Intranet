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
    $profile = $_GET['id'];


    // $sqlSearch="SELECT * FROM usuarios WHERE Id_empleado='$idUser'";
    // $resultado = $DB_conection->query($sqlSearch);
    // $imprimir = $resultado->fetch_assoc();

    $sqlInfo="SELECT * FROM usuarios WHERE Id_empleado='$profile'";
    $resultado2 = $DB_conection->query($sqlInfo);
    $showInfo = $resultado2->fetch_assoc();


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stock.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">
    <title>.:Perfil de <?php echo $showInfo['Apellido_p']. " ". $showInfo['Nombre']?>:.</title>
</head>
<body>
    <header>

        <?php include_once 'header.php';?>

    </header>

    <main class="contenedor main">
        <div class="portada">
            
        </div>
        <div class="servicios">
            <h2>Información del empleado</h2>
            <div class="doscolumnas">
            
                <div class="usuario">
                    <img src="<?php echo $showInfo['Foto']?>" width="250" height="250" style="border-radius:50%">
                </div>
                
                <div class="inf-emp">
                        <div class="inf">
                            <h3>Nombre del empleado</h3>
                            <table>
                                <tr>
                                    <td><?php echo $showInfo['Nombre'] .' '. $showInfo['Apellido_p'] .' '. $showInfo['Apellido_m']; ?></td>
                                </tr>
                            </table> 
                        </div>

                        <div class="inf">
                            <h3>sexo</h3>
                            <table>
                                <tr>
                                    <?php if($showInfo['Sexo']=='Femenino') { ?>
                                    <td><img src="https://img.icons8.com/office/16/000000/female.png"/><?php echo $showInfo['Sexo']; ?></td>
                                    <?php } else if($showInfo['Sexo']=='Masculino'){ ?>
                                    <td><img src="https://img.icons8.com/office/16/000000/male.png"/><?php echo $showInfo['Sexo']; ?></td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </div>
                        
                        
                        <div class="inf">
                            <h3>fecha de nacimiento</h3>
                            <table>
                                <tr>
                                    <td><?php echo $showInfo['Fecha_nac']; ?> </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="inf">
                            <h3>correo</h3>
                            <table>
                                <tr>
                                    <td><?php echo $showInfo['Email']; ?> </td>
                                </tr>
                            </table>
                        </div>
                        
                        
                        <div class="inf">
                            <h3>departamento</h3>
                            <table>
                                <tr>
                                    <td><?php echo $showInfo['Departamento']; ?> </td>
                                </tr>
                            </table>
                        </div>
                        <div class="inf">
                            <h3>turno</h3>
                            <table>
                                <tr>
                                    <td><?php echo $showInfo['Turno']; ?> </td>
                                </tr>
                            </table>
                        </div>
                        <div class="inf">
                            <h3>sucursal</h3>
                                <table>
                                    <tr>
                                        <td><?php echo $showInfo['Sucursal']; ?> </td>
                                    </tr>
                                </table>
                        </div>
                        <div class="inf">
                            <h3>estado</h3>
                            <table>
                                <tr>
                                    <?php if($showInfo['Estado']==1) { ?>
                                    <td><img src="https://img.icons8.com/material-outlined/24/26e07f/filled-circle--v1.png" width="15px" height="15px"/>Online</td>
                                    <?php } else if($showInfo['Estado']==0){ ?>
                                    <td><img src="https://img.icons8.com/material-outlined/24/fa314a/filled-circle--v1.png" width="15px" height="15px"/>Outline</td>
                                    <?php } ?>
                            </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div><!--dos columnas-->
                
        </div>
        <?php include_once 'footer.html';?>
    </main>

    
</body>
</html>