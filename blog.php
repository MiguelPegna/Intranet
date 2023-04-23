<?php
    #script de validacion de datos para registro de usuarios
    session_start();
    require 'includes/DB_conexion.php';
    require 'includes/funciones.php';
    #require 'includes/posting.php';

    if(!isset($_SESSION['id_usuario'])){
        header('Location: index.php');
    }

    $idUser = $_SESSION['id_usuario'];
    $accesos= $_SESSION['permisos'];

    $sqlPost="SELECT * FROM anuncios WHERE Estado =1 ORDER BY Id_anuncio desc";
    $posting = $DB_conection->query($sqlPost);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stock.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">
    
    <title>Anuncios || BLOG</title>
</head>
<body>
    <header>

        <?php include_once 'header.php';?>

    </header>

    <main class="contenedor main">
        <div class="portada">
            <?php if($accesos==1 or $accesos==2 or $accesos==3){ ?>
                <a class="btn btn-primary" href="nuevo-post.php"> + ESCRIBIR NUEVA ENTRADA</a><br/>
            <?php } ?>
        </div>
        <div class="servicios">
            
            
                <table class="table table-sm table-hover table-bordered "> 
                    <thead> 
                        <tr> 
                            <th></th>  
                            <th>De</th> 
                            <th>Titulo</th> 
                            <th>Descripcion</th> 
                            <th>Fecha</th> 
                            <!-- <th></th> -->
                        </tr> 
                    </thead> 
                    <tbody> 
                        <!-- seccion del while -->  
                    
                        <?php while($verPost = $posting-> fetch_array(MYSQLI_BOTH)) {  
                            #Consulta para mostrar el nombre del usuario que manda el mensaje por medio de su id 
                            $sqlUser="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Sucursal, Departamento, Foto FROM usuarios WHERE Id_empleado='".$verPost['Autor']."'"; 
                            $encontrar = $DB_conection->query($sqlUser); 
                            $user = $encontrar-> fetch_array(MYSQLI_BOTH);     
            
                            
                        ?> 
                            <tr> 
                                <td><a href="user.php?id=<?php echo $user['Id_empleado'] ?>"><img src="<?php echo $user['Foto']; ?>" title="<?php echo $user['Nombre']; ?>" width="50" height="50"/></a></td> 
                                <td><?php echo $user['Nombre'] .' '. $user['Apellido_p']; ?> <br/><?php echo $user['Departamento']; ?></td> 
                                <td><a href="anuncio.php?id=<?php echo $verPost['Id_anuncio']; ?>"  class="btn btn-outline-secondary btn-lg btn-block"><?php echo $verPost['Titulo']; ?> </a></td> 
                                <td><?php echo $verPost['Descripcion']; ?></td> 
                                <td><?php echo $verPost['Fecha']; ?></td> 
                                <!-- ?php if($accesos ==1 or $accesos == 2 or $accesos==3){ ?> -->
                                <!-- <td><a href="edit-anuncio.php?id=<?php echo $verPost['Id_anuncio']; ?>"><img src="img/trash.png" title="Enviar a papelera" width="25" heigth="25"></a></td> 
                                <php } ?> -->
                            </tr> 
                        <?php } ?> 
                    </tbody> 
                    <tfoot> 
                    
                    </tfoot> 
                </table>
            </div>
        <?php include_once 'footer.html';?>
    </main>
</body>
</html>