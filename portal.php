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

    #Consultas a la db
    #Consulta info usuarios
    $sqlSearch="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Foto, Turno, Departamento, Sucursal, Permisos Estado FROM usuarios WHERE Id_empleado='$idUser' LIMIT 1";
    $resultado = $DB_conection->query($sqlSearch);
    $imprimir = $resultado->fetch_assoc();

    #Consulta user online
    $sqlOnline="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Foto, Turno, Departamento, Sucursal, Estado FROM usuarios WHERE Estado=1 LIMIT 5";
    $usuarios = $DB_conection->query($sqlOnline);

    #Consulta cumpleaños
    $sqlCumple="SELECT Id_empleado, Nombre, Apellido_p, Turno, Departamento, Foto, DATE_FORMAT(Fecha_nac, '%d - %b') AS Cumple FROM usuarios WHERE 1 = (FLOOR(DATEDIFF(DATE_ADD(DATE(NOW()),INTERVAL 15 DAY),Fecha_nac) / 365.25)) - (FLOOR(DATEDIFF(DATE(NOW()),Fecha_nac) / 365.25)) ORDER BY MONTH(Fecha_nac),DAY(Fecha_nac) LIMIT 5";
    $cumpleanhos = $DB_conection->query($sqlCumple);

    #Consulta anuncios
    $sqlAnuncios="SELECT * FROM anuncios ORDER BY Fecha DESC LIMIT 5";
    $anuncios = $DB_conection->query($sqlAnuncios); 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Inicio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">
    <title>.:Portal de <?php echo $imprimir['Apellido_p']. " ". $imprimir['Nombre'];?>:.</title>
</head>
<body>

    <header>

        <?php include_once 'header.php';?>

    </header>
    
    <main class="contenedor main">
        <div class="portada">
            
        </div>
   

        <div class="servicios ">
            <h2>Hola <?php echo $imprimir['Nombre']. " ". $imprimir['Apellido_p']?> al portal de inicio</h2>
            <div class="servicios2"> 
                <div class="cuadroServ">
                    <div class="infoSer">
                        <a href="stock.php">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-basket" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <polyline points="7 10 12 4 17 10" />
                                <path d="M21 10l-2 8a2 2.5 0 0 1 -2 2h-10a2 2.5 0 0 1 -2 -2l-2 -8z" />
                                <circle cx="12" cy="15" r="2" />
                            </svg>
                            <p>Productos Stock</p>
                        </a>
                        
                    </div>
                    <div class="infoSer">
                        <a href="clientes.php">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="9" cy="7" r="4" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                            <p>Clientes</p>
                        </a>
                        
                    </div>
                    <div class="infoSer">
                        <a href="proveedores.php">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-forklift" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="5" cy="17" r="2" />
                                <circle cx="14" cy="17" r="2" />
                                <line x1="7" y1="17" x2="12" y2="17" />
                                <path d="M3 17v-6h13v6" />
                                <path d="M5 11v-4h4" />
                                <path d="M9 11v-6h4l3 6" />
                                <path d="M22 15h-3v-10" />
                                <line x1="16" y1="13" x2="19" y2="13" />
                            </svg>
                            <p>Proovedores</p>
                        </a>
                        
                    </div>
                    <div class="infoSer">
                        <a href="galerias/galeria.php">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-area-line" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <polyline points="4 19 8 13 12 15 16 10 20 14 20 19 4 19" />
                                <polyline points="4 12 7 8 11 10 16 4 20 8" />
                            </svg>
                            <p>Galería</p>
                        </a>
                        
                    </div>
                    <div class="infoSer">
                        <a href="blog.php">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-alert" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                                <line x1="12" y1="11" x2="12" y2="14" />
                            </svg>
                            <p>Avisos</p>
                        </a>
                        
                    </div>
                    <div class="infoSer">
                        <a href="formatos.php">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                                <line x1="9" y1="7" x2="13" y2="7" />
                                <line x1="9" y1="11" x2="13" y2="11" />
                            </svg>
                            <p>Formatos</p>
                        </a>
                        
                    </div>
                    <div class="infoSer">
                        <a href="buzon.php">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-inbox" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <rect x="4" y="4" width="16" height="16" rx="2" />
                                <path d="M4 13h3l3 3h4l3 -3h3" />
                            </svg>
                            <p>Buzón de sugerencias</p>
                        </a>
                        
                    </div>
                    <div class="infoSer">
                        <a href="user.php?id=<?php echo $idUser ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="12" cy="7" r="4" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                            <p>Mi perfíl</p>
                        </a>
                        
                    </div>
                    <div class="infoSer">
                        
                        <a href="organigrama.php">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-dots" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 3v18h18" />
                            <circle cx="9" cy="9" r="2" />
                            <circle cx="19" cy="7" r="2" />
                            <circle cx="14" cy="15" r="2" />
                            <line x1="10.16" y1="10.62" x2="12.5" y2="13.5" />
                            <path d="M15.088 13.328l2.837 -4.586" />
                            </svg>
                            <p>Organigrama</p>
                        </a>
                        
                    </div>
                    <div class="infoSer">
                        <?php if($accesos==1 or $accesos==2){ ?>
                        <a href="lista-usuarios.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="9" y1="6" x2="20" y2="6" />
                                    <line x1="9" y1="12" x2="20" y2="12" />
                                    <line x1="9" y1="18" x2="20" y2="18" />
                                    <line x1="5" y1="6" x2="5" y2="6.01" />
                                    <line x1="5" y1="12" x2="5" y2="12.01" />
                                    <line x1="5" y1="18" x2="5" y2="18.01" />
                                    </svg>
                            <p>Lista Empleados</p>
                        </a>
                        
                    </div>

                    <div class="infoSer">
                        
                            <a href="crear_cuenta.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 11h6m-3 -3v6" />
                                    </svg>
                                <p>Registrar</p>
                            </a>
                        <?php }?>
                    </div>
                    

                    
                    <div class="infoSer">
                        <?php if($accesos==1 or $accesos==2 or $accesos==3){ ?>
                            <a href="nuevo-post.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-template" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="4" y="4" width="16" height="4" rx="1" />
                                    <rect x="4" y="12" width="6" height="8" rx="1" />
                                    <line x1="14" y1="12" x2="20" y2="12" />
                                    <line x1="14" y1="16" x2="20" y2="16" />
                                    <line x1="14" y1="20" x2="20" y2="20" />
                                    </svg>
                                <p>Publicar</p>
                            </a>
                        <?php }?>
                    </div>
                    
                    
                </div>

                <div class="aside">                   
                    <div class="usuariosOnline caja-aside">
                        <h3>Usuarios online</h3>
                        <table class="table table-sm table-hover">
                            <!-- <tbody> -->
                                <?php while ($verUser = $usuarios->fetch_assoc()){ ?>
                                    <tr>
                                        <td><a href="user.php?id=<?php echo $verUser['Id_empleado'] ?>"> <img src="<?php echo $verUser['Foto']; ?>" title="<?php echo $verUser['Nombre']. " " .$verUser['Apellido_p']?>" width="30" heigth="30" class="rounded-circle" style="border: 2.5px solid #7FFF00;"> </a></td>
                                        <td><?php echo $verUser['Nombre']; ?> <?php echo $verUser['Apellido_p']; ?> </td>
                                        <td>Suc: <?php echo $verUser['Sucursal']; ?></td>
                                        <td>Depto: <?php echo $verUser['Departamento']; ?></td>
                                    </tr>
                                <?php } ?>
                            <!-- </tbody> -->                           
                        </table>

                    </div> <!--usuariosOnline-->

                    <div class="Cumpleaños caja-aside">
                        <h3>Próximos cumpleaños</h3>
                        <table class="table table-sm table-hover">
                            <!-- <tbody> -->
                                <?php while ($verCumple = $cumpleanhos->fetch_assoc()) { ?>
                                    <tr>
                                        <td><a href="user.php?id=<?php echo $verCumple['Id_empleado'] ?>"> <img src="<?php echo $verCumple['Foto']; ?>" title="<?php echo $verCumple['Nombre']. " " .$verCumple['Apellido_p']?>" width="30" heigth="30" class="rounded-circle" style="border: 2.5px solid #5DADE2;"> </a></td>
                                        <td><?php echo $verCumple['Nombre']; ?> <?php echo $verCumple['Apellido_p']; ?> </td>
                                        <td>Turno: <?php echo $verCumple['Turno']; ?></td>
                                        <td>Depto: <?php echo $verCumple['Departamento']; ?></td>
                                        <td><?php echo $verCumple['Cumple']; ?> </td>
                                    </tr>
                                <?php } ?>
                            <!-- </tbody> -->                           
                        </table>
                    </div> <!--Cumpleaños-->

                    <div class="Anuncios caja-aside">
                        <h3>Avisos Recientes</h3>
                        <table class="table table-sm table-hover">
                            <!-- <tbody> -->
                                <?php while ($verPost = $anuncios->fetch_assoc()){ ?>
                                    <tr>
                                        <td><a href="anuncio.php?id=<?php echo $verPost['Id_anuncio'] ?>"class="btn btn-outline-secondary btn-lg btn-block" > <?php echo $verPost['Titulo']; ?> </td>
                                        <td>Fecha: <?php echo $verPost['Fecha']; ?></td>
                                    </tr>
                                <?php } ?>
                            <!-- </tbody> -->                           
                        </table>

                    </div> <!--anuncios-->
                </div>
            </div>
        </div>

        <?php include_once 'footer.html';?>

    </main>

</body> 
</html>