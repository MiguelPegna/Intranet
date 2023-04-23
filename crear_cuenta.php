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

    if($accesos==3 or $accesos==4){
        header('Location: index.php');
    }

    $errores = array();
    if(!empty($_POST)){
        $varNombre = $DB_conection->real_escape_string(ucwords($_POST['tnombre']));
        $varApellido_p = $DB_conection->real_escape_string(ucwords($_POST['tapellido_p']));
        $varApellido_m = $DB_conection->real_escape_string(ucwords($_POST['tapellido_m']));
        $varFecha_nac = $DB_conection->real_escape_string($_POST['tfecha']);
        $varRFC = $DB_conection->real_escape_string(strtoupper($_POST['trfc']));
        $varSexo = $DB_conection->real_escape_string($_POST['tsexo']);
        $varCalle = $DB_conection->real_escape_string(ucwords($_POST['tcalle']));
        $varCol = $DB_conection->real_escape_string(ucwords($_POST['tcol']));
        $varCP = $DB_conection->real_escape_string($_POST['tcp']);
        $varEntidad = $DB_conection->real_escape_string(ucwords($_POST['tentidad']));
        $varTel = $DB_conection->real_escape_string($_POST['ttel']);
        $varSucursal = $DB_conection->real_escape_string($_POST['tsucursal']);
        $varTurno = $DB_conection->real_escape_string($_POST['tturno']);
        $varDepto = $DB_conection->real_escape_string($_POST['tdepto']);
        $varCorreo = $DB_conection->real_escape_string($_POST['tmail']);
        $varPass01 = $DB_conection->real_escape_string($_POST['tpass01']);
        $varPass02 = $DB_conection->real_escape_string($_POST['tpass02']);
        $activo =0;
        $permisos=4;

        $captcha = $DB_conection->real_escape_string($_POST['g-recaptcha-response']);
        $datoC ='6Lfkop0aAAAAAO8Eq1sypoiGXRWA0arIRN6-9UcX';

        if(!$captcha){
            $errores[] ="Verifica el captcha";
        }

        if(checarDatos($varNombre, $varApellido_p, $varApellido_m, $varFecha_nac, $varRFC, $varSexo, $varCalle, $varCol, $varCP, $varEntidad, $varTel, $varSucursal, $varTurno, $varDepto, $varCorreo, $varPass01, $varPass02)){
            $errores[] ="Llena TODOS los campos";
        }

        if(!esMail($varCorreo)){
            $errores[] ="El E-mail no es valido";
        } 

        if(!validarPass($varPass01, $varPass02)){
            $errores[] ="Las contraseñas no son iguales";
        }

        if(mailExiste($varCorreo)){
            $errores[] ="El correo que ingresaste ya esta registrado";
        }

        if(count($errores)==0){
            $respuestaCaptcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$datoC&response=$captcha");
            $arr= json_decode($respuestaCaptcha, TRUE);
            if($arr['success']){
                $cifrarPass = passSeguro ($varPass01);
                $token = creaToken();
                $crearCuenta = creaUsuario($varNombre, $varApellido_p, $varApellido_m, $varFecha_nac, $varRFC, $varSexo, $varCalle, $varCol, $varCP, $varEntidad, $varTel, $varSucursal, $varTurno, $varDepto, $varCorreo, $cifrarPass, $activo, $token, $permisos);
                if($crearCuenta >0){
                    $url ='http://'.$_SERVER["SERVER_NAME"].'/intranet/activar_cuenta.php?id='.$crearCuenta.'&val='.$token;
                    $asunto='Activar cuenta de empleado de Game Store';
                    $mensaje="Hola $varNombre: <br/>Para concluir tu registro como empleado de Game Store y tener acceso al sistema de empleados da click en el sig enlace: <a href='$url'>Click Aqui</a>";
                    if(enviarMail($varCorreo, $varNombre, $asunto, $mensaje)){
                        echo"Para terminar el registro revisa tu correo electronico ".$varCorreo. " para poder activar tu cuenta"."<br>";
                        echo"<a href='index.php'> Iniciar Sesion </a>";
                        exit; 
                    }
                    else{
                        $errores[] = 'No se pudo enviar correo de activacion';
                    }
                }
                else{
                    $errores[] = 'Todo lo que ha podido fallar lo ha hecho';
                }
            }
            else {
                $errores[] ='Fallo al comprobar captcha';
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <title>Registro de usuario</title>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-RXf+QSDCUQs5uwRKaDoXt55jygZZm2V++WUZduaU/Ui/9EGp3f/2KZVahFZBKGH0s774sd3HmrhUy+SgOFQLVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <script type="text/javascript" src="js/validaForm.js"></script>
</head>
<body>
    <div class="Inicio">
        <a href="portal.php" title="inicio">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-gamepad" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <rect x="2" y="6" width="20" height="12" rx="2" />
                <path d="M6 12h4m-2 -2v4" />
                <line x1="15" y1="11" x2="15" y2="11.01" />
                <line x1="18" y1="13" x2="18" y2="13.01" />
            </svg>
        </a>
    </div>
    
    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>"> 
        <div class="contenedor">
            <div class="item">     
                <label for="nombre">NOMBRE(S)</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input mayus" name="tnombre" />
            </div>

            <div class="item">
                <label for="apellido_p">APELLIDO PATERNO</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input mayus" name="tapellido_p"/>
            </div>

            <div class="item">                
                <label for="apellido_m">APELLIDO MATERNO</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input mayus" name="tapellido_m"/>
            </div>

            <div class="item">     
                <label for="fecha">FECHA DE NACIMIENTO</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="date" class="form--input" name="tfecha"/>
            </div>

            <div class="item">
                <label for="rfc">RFC</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input mayus" name="trfc"/>
            </div>

            <div class="item">
                <label for="Sexo">SEXO</label><br/>
                    <select class="form--input" name="tsexo">
                        <option value="Masculino">MASCULINO</option>
                        <option value="Femenino">FEMENINO</option>
                    </select>
            </div>

            <div class="item">
                <label for="calle">CALLE</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input mayus" name="tcalle"/>
            </div>

            <div class="item">
                <label for="colonia">COLONIA</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input mayus" name="tcol"/>
            </div>

            <div class="item">
                <label for="entidad">DELG. o MPIO.</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input mayus" name="tentidad"/>
            </div>

            <div class="item">
                <label for="cp">CÓDIGO POSTAL</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input" name="tcp"/>
            </div>

            <div class="item">
                <label for="telefono">TELÉFONO</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input" name="ttel"/>
            </div>

            <div class="item">

            </div>

            <div class="item">
                <label for="sucursal">SUCURSAL</label><br/>
                <select class="form--input" name="tsucursal">
                    <option value="Centro">CENTRO</option>
                    <option value="Norte">NORTE</option>
                    <option value="Sur">SUR</option>
                </select>
            </div>

            <div class="item">
                <label for="turno">TURNO</label><br/>
                <select class="form--input" name="tturno">
                    <option value="Matutino">MATUTINO</option>
                    <option value="Vespertino">VESPERTINO</option>
                </select>
            </div>

            <div class="item">
                <label for="depto">DEPARTAMENTO</label><br/>
                <select class="form--input" name="tdepto">
                    <option value="Finanzas">FINANZAS</option>
                    <option value="Sistemas">SISTEMAS</option>
                    <option value="Almacén">ALMACÉN</option>
                    <option value="Recursos Humanos">RECURSOS HUMANOS</option>
                    <option value="Dirección General">DIRECCIÓN GENERAL</option>
                </select>
            </div>

            <div class="item">
                <label for="email">CORREO ELECTRÓNICO</label><span class="obligatorio">&nbsp;*</span><br/>
                <input type="text" class="form--input" name="tmail"/>
            </div>

            <div class="item">
                <label for="pass01">CONTRASEÑA</label><span class="obligatorio">&nbsp;*&nbsp;</span> <a href="javascript:verPass01();" title="Mostrar Contraseña"><i class="fa fa-eye" aria-hidden="true" ></i></a><br/>
                <input type="password" class="form--input" name="tpass01" id="ver01"/>
            </div>

            <div class="item">
                <label for="pass02">REPITE CONTRASEÑA</label><span class="obligatorio">&nbsp;*&nbsp;</span> <a href="javascript:verPass02();" title="Mostrar Contraseña" class="eye"><i class="fa fa-eye" aria-hidden="true" ></i></a><br/>
                <input type="password" class="form--input" name="tpass02" id="ver02" />
            </div>

            <div class="item">
                    
            </div>

            <div class="item item--boton">
                <input class="btn--enviar" type="submit" value="CREAR CUENTA"> 
            </div>

            <div class="item"></div>
        
            </div>

            <div class="contenedor2">
                <div class="error">
                    <?php
                    echo listaErrores($errores);
                    ?>
                </div>

                <div class="g-recaptcha" data-sitekey="6Lfkop0aAAAAALxqGCNGtxSbty7GGb0jFa5dnFPb"></div>
            </div>

        </div>
    </form>

    
</body>
</html>