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


    $sqlClientes="SELECT * FROM clientes WHERE Estado=1";
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
                <a class="btn btn-primary" href="add-cliente.php"> + AGREGAR NUEVO CLIENTE</a><br/>
            <?php } ?>
        </div>
        <div class="servicios stockclientes">
            <h2>Lista de clientes</h2>

            <div class="clientes">
                <div class="clientesScroll">
                    <!-- seccion del while -->           
                    <?php while($cliente = $resultado2->fetch_assoc()) { ?> 
                    <div class="bloque blclientes">
                        <?php if($accesos==1){ ?>
                        <a class="btn btn-info" href="edit-cliente.php?id=<?php echo $cliente['Id_cliente'];?> ">Editar</a> <br/>
                        <?php } ?>
                        <?php echo $cliente['Nombre']; ?><br/>
                        <img src="<?php echo $cliente['Foto']?>" width="150" height="150" title="<?php echo $cliente['Nombre'] ?>"><br/>
                        Representante: <?php echo $cliente['Representante']?><br/>
                        Teléfono: <?php echo $cliente['Telefono']?><br/>
                        E-mail: <?php echo $cliente['Email']?><br/>
                        Dirección: <?php echo $cliente['Direccion']?><br/>
                        RFC : <?php echo $cliente['RFC']?><br/>
                    </div>
                    <?php } ?>
                </div>
            </div>   
        </div>
        <?php include_once 'footer.html';?>

    </main>
    
</body>
</html>