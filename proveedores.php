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

    $sqlClientes="SELECT * FROM proveedores WHERE Estado=1";
    $resultado2 = $DB_conection->query($sqlClientes);
?>
<!DOCTYPE html PUBLIC>
<html lang="es">
<head>
    <title>.:Lista de Clientes:.</title>
    <link rel="stylesheet" type="text/css" href="css/stock.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/88d10ff1ee.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
    <header>

        <?php include_once 'header.php';?>

    </header>

    <main class="contenedor main">
        <div class="portada">
            <?php if($accesos==1){ ?>
                <a class="btn btn-primary" href="add-proveedor.php"> + AGREGAR NUEVO PROVEEDOR</a><br/>
            <?php } ?>
        </div>
        <div class="servicios stockclientes">
           
            <h2>Lista de Proveedores</h2>

            <div class="clientes">
                <div class="clientesScroll">
                     <!-- seccion del while -->           
             <?php while($proveedor = $resultado2->fetch_assoc()) { ?> 
            <div class="bloque blclientes">
                <?php if($accesos==1){ ?>
                    <a class="btn btn-info" href="edit-proveedor.php?id=<?php echo $proveedor['Id_proveedor'];?> ">Editar</a> <br/>
                <?php } ?>
                <?php echo $proveedor['Nombre_empresa']; ?><br/>
                <img src="<?php echo $proveedor['Foto']?>" width="150" height="150" title="<?php echo $proveedor['Nombre_empresa'] ?>"><br/>
                Teléfono: <?php echo $proveedor['Telefono']?><br/>
                E-mail: <?php echo $proveedor['Email']?><br/>
                Dirección: <?php echo $proveedor['Direccion']?> <br/>
                CP: <?php echo $proveedor['CP']?><br/>
                RFC : <?php echo $proveedor['RFC']?><br/>               
            </div>

            <?php } ?>
                </div>
            </div>  
            
                
        </div>
        <?php include_once 'footer.html';?>
    </main>
    
    
</body>
</html>