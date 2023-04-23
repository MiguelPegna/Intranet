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

    $sqlStock="SELECT * FROM productos WHERE Estado=1";
    $resultado2 = $DB_conection->query($sqlStock);
?>
<!DOCTYPE html PUBLIC>
<html lang="es">
<head>
    <title>.:Stock de Productos:.</title>
    <link rel="stylesheet" type="text/css" href="css/stock.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/88d10ff1ee.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type='text/javascript' src='js/x.js'></script>
    
    <script type='text/javascript'>
        function muestra_imagen(archivo,ancho,alto){
            //xInnerHtml('c1','')
            xWidth ('ampliacion',ancho + 6)
            xHeight ('ampliacion',alto + 6 + 20)
            xWidth ('c1',ancho)
            xHeight ('c1',alto)
            xWidth ('cerrarampliacion',ancho) 
            xInnerHtml('c1','<img src="' + archivo + '" width="' + ancho + '" height="' + alto + '" border="0">') 
            xShow('ampliacion');
        }
        function cerrar_ampliacion(){
            xHide('ampliacion');  
        }
        window.onload = function(){
        }
    </script>

    

</head>
<body>
    <!--Bloques de la ampliacion de imagen-->
    <div id="ampliacion" style="padding: 2px; position:absolute; left: 56rem; top: 20rem; visibility: hidden; border: 1px solid #666666; background-image: url(img/tenor.gif); background-repeat: no-repeat;">
        <div id="c1">
        </div>

        <div id="cerrarampliacion" style="background-color:333333; font-family:arial,verdana; font-size:8pt; line-height:20px; text-align:right;float:right; height: 20px; padding-right:5px;">
            <a href="javascript:cerrar_ampliacion()" style="color:#ffffff;">[X] Cerrar</a><br>
        </div>
    </div> 
    <!--cierre de Bloques de la ampliacion de imagen-->

    <header>

        <?php include_once 'header.php';?>

    </header>

    <main class="contenedor main">
        <div class="portada">
            <?php if($accesos==1){ ?>
                <a class="btn btn-primary" href="add-producto.php"> + AGREGAR NUEVO PRODUCTO</a><br/>
            <?php } ?>
        </div>
        <div class="servicios">
            
            <h2>Productos </h2>
            <div class="tabla1">
                <div class="tabla2">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Cant.</th>
                                <th>Producto</th>
                                <th>Marca</th>
                                <th>Precio</th>
                                <th>Categoria</th>
                                <th>Descripción</th>
                                <?php if($accesos==1){ ?>
                                    <th> </th>
                                <?php }?>                         
                            </tr>
                        </thead>

                        <tbody>
                            <!-- seccion del while -->  
                                   
                            <?php while($producto = $resultado2->fetch_assoc()) { ?> 
                                <tr>
                                    <td><?php echo $producto['Num_piezas']; ?></td>
                                    <td> <a href="javascript:muestra_imagen('<?php echo $producto['Foto'] ?>',180,310)" title="<?php echo $producto['Descripcion']?>" class="btn btn-outline-secondary btn-lg btn-block"> <?php echo $producto['Producto'] ?></a> </td>
                                    <td><?php echo $producto['Marca']; ?></td>
                                    <td><?php echo '$ '. $producto['Precio']; ?></td>
                                    <td><?php echo $producto['Categoria']; ?></td>
                                    <td><?php echo $producto['Descripcion']; ?></td>
                                    <?php if($accesos==1){ ?>
                                        <td><a href="edit-producto.php?id=<?php echo $producto['Id_producto'];?>" class="btn btn-secondary">Editar </a></td>
                                    <?php }?>                                         
                                </tr>    
                            <?php } ?>
                        </tbody>
                    </table>  
                </div>  
            </div>
        </div>
        <?php include_once 'footer.html';?>
    </main>
 
    <!-- <script> 
        $('#confirm-delete').on('show.bs.modal', function(e){
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href')+ '</strong>');
        });
    </script> -->
</body>
</html>
