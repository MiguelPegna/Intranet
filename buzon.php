<?php
    #script de validacion de datos para registro de usuarios
    session_start();
    require 'includes/DB_conexion.php';
    require 'includes/mensajeria.php';

    if(!isset($_SESSION['id_usuario'])){
        header('Location: index.php');
    }

    $idUser = $_SESSION['id_usuario'];
    $accesos= $_SESSION['permisos'];

    $sqlInfo="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Email, Sucursal, Turno, Departamento FROM usuarios WHERE Id_empleado='$idUser'";
    $resultado2 = $DB_conection->query($sqlInfo);
    $showInfo = $resultado2->fetch_assoc();

    $errores = array();
    //Este es el correo que estara recibiendo los mensajes del buzon de sugerencias
    $buzon='ma.pena.t@edu.utc.mx';

    $remitente= utf8_decode('<b>' .'Nombre empleado: '. '</b>' .$showInfo['Nombre'] .' '. $showInfo['Apellido_p'] .' '. $showInfo['Apellido_m'] .' <br/><b>Sucursal: </b>'. $showInfo['Sucursal'] .' <br/><b>Turno: </b>'. $showInfo['Turno'] .' <br/><b>Depto: </b>'. $showInfo['Departamento'] .' <br/><b> Email: </b>'. $showInfo['Email']);

    if(!empty($_POST)){
        $varAsunto = utf8_decode($_POST['tasunto']);
        $varSugerencia = utf8_decode($_POST['tsugerencia']);

        if(revInputs($varAsunto, $varSugerencia)){
            $errores[] ="Llena TODOS los campos";
        }

        if(count($errores)==0){
            $mensaje=utf8_decode("Hola este mensaje proviene del buzón de sugerencias por parte de: <br/> $remitente. <br/><b>Con la siguiente sugerencia. </b><br/>$varSugerencia <br/><br/>Se pide dar el segumiento correspondiente. <br/>ATT: Equipo de GAME STORE");
            if(enviarMail($buzon, $varAsunto, $mensaje)){
                echo "<script>alert('Tu sugerencia se ha mandado correctamente. A la cual se le estara dando seguimiento')</script>";
            }
            else{
                $errores[] = 'No se pudo enviar tu sugerencia :(';
            }
        }
    } 

?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Inicio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="https://kit.fontawesome.com/88d10ff1ee.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>   
    

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
    <title>.:Buzón de sugerencias:.</title>
</head>
<body>
    <header>

        <?php include_once 'header.php';?>

    </header>

    <main class="contenedor main">
        <div class="portada">
        <div class="error">
            <?php
                    echo listaErrores($errores);
                ?>
            </div>
        </div>

        <div class="servicios">
            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                <h2>Buzón de sugerencias</h2><br/>
                <div class="cajaM">                                
                    <div class="tabla"> 
                        <h2>                   
                            <label>Asunto</label>
                            <input type="text" name="tasunto"><br/>
                            <textarea class="texto" type="text" name="tsugerencia" rows="5" placeholder="Escribe tu sugerencia: Esto nos servira para conocer areas de oportunidad y mejorar continuamente para el beneficio de todos los que laboramos en Game Store."></textarea>
                            <br/>
                            <input class="btn btn-warning" type="reset" value="BORRAR" style="font-size:2rem;"> 
                            <input class="btn btn-success" type="submit" value="ENVIAR" style="font-size:2rem;">
                        </h2>
                    </div>
                </div>
            </form> 
        <?php include_once 'footer.html';?>      
    </main>
    
</body>
</html>