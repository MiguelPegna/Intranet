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

    $sqlDoc="SELECT * FROM formatos WHERE Estado=1 ORDER BY Fecha DESC";
    $formatos = $DB_conection->query($sqlDoc); 

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
    </style>
    <title>.:Formatos:.</title>
</head>
<body>

    <header>

        <?php include_once 'header.php';?>

    </header>
    
    <main class="contenedor main">
        <div class="portada">
            
        </div>
   

        <div class="servicios ">
            <h2>Formatos y solicitudes disponibles.</h2>
            <div class="servicios2"> 
                <div class="tabla">
                    Para descargar el formato o solicitud necesaria solo da click en el archivo que requieras o haz click derecho sobre el enlace y selecciona la opción de guardar destino como.<br/>
                    <?php if($accesos==1){ ?>
                        <span class="bg-danger letra">Usuario con permisos para gestionar esta sección para quitar un documento de la lista haz doble click sobre el botón de borrar correspondiente al documento que desees remover.</span><br/>
                    <?php }?><br/>

                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th> </th>
                                <th>Nombre del documento</th>
                                <th>Tamaño</th>
                                <th>Fecha</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($verDoc = $formatos->fetch_assoc()){ ?>
                            <tr>
                                <td><img src="img/<?php echo $verDoc['Extension']; ?>.png" width="25" heigth="25" /></td>
                                <td><a href="<?php echo $verDoc['Ruta'] ?>" class="btn btn-outline-secondary btn-lg btn-block" > <?php echo $verDoc['Documento']; ?> </a> </td>
                                <td><?php $varFloat=$verDoc['Size']/1024;?><?php echo number_format($varFloat, 0) .'KB'; ?> </td>
                                <td><?php echo $verDoc['Fecha']; ?></td>
                                <td>
                                    <?php if($accesos==1){ ?>                        
                                        <a onclick="return false" ondblclick="location=this.href" href="borrar-formato.php?id=<?php echo $verDoc['Id_doc'];?>" title="Para borrar de doble click" class="btn btn-outline-danger btn-lg btn-block">Borrar</a> 
                                    <?php }?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>                          
                    </table>
                </div>  
                

                <div class="aside">                   
                    <div class="usuariosOnline caja-aside">
                        
                        <form method="post" action="upload.php" enctype="multipart/form-data">
                            

                            <?php if($accesos ==1 or $accesos == 2 or $accesos==3){ ?>
                                <h2>Subir nuevo documento
                                <br/>
                                Selecciona el documento que deseas subir.<br/>
                                <span class="bg-danger letra">NOTA: Solo puedes subir los sig archivos.</span>
                                <ul style="list-style:none">
                                    <li> <img src="img/docx.png" width="25" heigth="25" /> Archivos word </li>
                                    <li> <img src="img/pdf.png" width="25" heigth="25" /> Archivos pdf </li>
                                    <li> <img src="img/xlsx.png" width="25" heigth="25" /> Archivos excel </li>
                                    <li> <img src="img/pptx.png" width="25" heigth="25" /> Archivos power point </li>
                                    <li> <img src="img/jpg.png" width="25" heigth="25" /> Imagenes jpg </li>
                                    <li> <img src="img/png.png" width="25" heigth="25" /> Imagenes png </li>
                                </ul>
                                 <br/>
                                <input type="file" name="archivo" class="btn btn-primary" value="Subir Formato" /><br/><br/>
                                <button class="btn btn-success">SUBIR ARCHIVO</button></h2>
                            <?php }else if($accesos==4){?>
                                <h2>Sección de documentos.</br></br>
                                <img src="img/docs.png" />
                            <?php }  ?>
                        </form>

                    </div> <!--usuariosOnline-->

                    
                </div>
            </div>
        </div>

        <?php include_once 'footer.html';?>

    </main>

</body> 
</html>