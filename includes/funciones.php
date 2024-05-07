<?php
    #FUNCIONES PARA EL REGISTRO DE USUARIOS
    #REvisamos que los datos del  formulario esten completos
    function checarDatos($varNombre, $varApellido_p, $varApellido_m, $varFecha_nac, $varRFC, $varSexo, $varCalle, $varCol, $varCP, $varEntidad, $varTel, $varSucursal, $varTurno, $varDepto, $varCorreo, $varPass01, $varPass02){
        if(strlen(trim($varNombre)) <1 || strlen(trim($varApellido_p)) <1 || strlen(trim($varApellido_m)) <1 || strlen(trim($varFecha_nac)) <1 || strlen(trim($varRFC)) <1 || strlen(trim($varSexo)) <1 || strlen(trim($varCalle)) <1 || strlen(trim($varCol)) <1 || strlen(trim($varCP)) <1 || strlen(trim($varEntidad)) <1 || strlen(trim($varTel)) <1 || strlen(trim($varSucursal)) <1 || strlen(trim($varTurno)) <1 || strlen(trim($varDepto)) <1 || strlen(trim($varCorreo)) <1 || strlen(trim($varPass01)) <1 || strlen(trim($varPass02)) <1){
            return true;            
        }
        else {
            return false;
        }
    }

    #Verificamos que se esta igresando una direccion de correo valida
    function esMail ($varCorreo){
        if(filter_var($varCorreo, FILTER_VALIDATE_EMAIL)){
            return true;            
        }
        else {
            return false;
        }
    }

    #Se comprueba de que los campos de password sean iguales
    function validarPass($var01, $var02){
        if(strcmp($var01, $var02)!==0){
            return false;            
        }
        else {
            return true;
        }
    }

    #Se comprueba que el correo ingresado no exista en la base de datos
    function mailExiste ($varCorreo){
        global $DB_conection;
        $consulta = $DB_conection -> prepare ('SELECT Id_empleado FROM usuarios WHERE Email = ? LIMIT 1');
        $consulta->bind_param("s", $varCorreo);
        $consulta->execute();
        $consulta->store_result();
        $fila = $consulta->num_rows;
        $consulta ->close();

        if($fila >0){
            return true;
        }
        else{
            return false;
        }
    }
    
    #Cifra el password para darle mayor seguridad
    function passSeguro($varPass01){
        $cifrar = password_hash($varPass01, PASSWORD_DEFAULT);
        return $cifrar;
    }

    #Crea token para el manejo de pass
    function creaToken(){
        $crear= md5(uniqid(mt_rand(), false));
        return $crear;
    }

    #Se ejecuta la funcion para ingresar los datos en la base de datos
    function creaUsuario($varNombre, $varApellido_p, $varApellido_m, $varFecha_nac, $varRFC, $varSexo, $varCalle, $varCol, $varCP, $varEntidad, $varTel, $varSucursal, $varTurno, $varDepto, $varCorreo, $cifrarPass, $activo, $token, $permisos){
        global $DB_conection;
        $consulta = $DB_conection->prepare("INSERT INTO usuarios (Nombre, Apellido_p, Apellido_m, Fecha_nac, RFC, Sexo, Calle, Colonia, CP, Entidad, Telefono, Sucursal, Turno, Departamento, Email, Pass, Activacion, Token, Permisos) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $consulta->bind_param('ssssssssisssssssisi', $varNombre, $varApellido_p, $varApellido_m, $varFecha_nac, $varRFC, $varSexo, $varCalle, $varCol, $varCP, $varEntidad, $varTel, $varSucursal, $varTurno, $varDepto, $varCorreo, $cifrarPass, $activo, $token, $permisos);
        if($consulta->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }

    #Funcion que permite enviar correo
    function enviarMail($varCorreo, $varNombre, $asunto, $mensaje){
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        try{
            $correo="vectormirror@gmail.com";
            $pass="password";
            $myHost="smtp.gmail.com";
            $puerto= "587";
            $deParte="Asistente Game Store";
            $SMTP_Auth="login";
            $seguridad="tls";

            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug=0;
            $mail->Host = $myHost;
            $mail->Port = $puerto; 
            $mail->SMTPAuth =$SMTP_Auth;      
            $mail->SMTPSecure =$seguridad;  
            $mail->Username = $correo;
            $mail->Password =$pass;  
            $mail->setFrom($correo, $deParte);

            $mail->addAddress($varCorreo, $varNombre);
            $mail->Subject =$asunto;
            $mail->Body = $mensaje;
            $mail->isHTML(true);
            
            if ($mail->send())
                return true;
                else
                return false;
        }catch(Exception $e){
        }
    }

    #Se crea la lista de posibles errores 
    function listaErrores($errores){
        if(count($errores) >0){
            echo"<div id='error' class='alert alert alert-danger'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\"> [X]</span>
            <ul>";
            foreach ($errores as $error){
                echo "<li>". $error. "</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
    }

    #Se valida el token para la activacion de la cuenta de usuarios
    function validarToken($id, $token) {
        global $DB_conection;
        $consulta= $DB_conection->prepare('SELECT Activacion FROM usuarios WHERE Id_empleado = ? AND Token = ? LIMIT 1');
        $consulta->bind_param('is', $id, $token);
        $consulta->execute();
        $consulta->store_result();
        $fila = $consulta->num_rows;

        if($fila >0){
            $consulta->bind_result($activacion);
            $consulta->fetch();
            if($activacion == 1){
                $message ='Esta cuenta ya ha sido activada con anterioridad';
            }
            else{
                if(activaUsuario($id)){
                    $message ='Cuenta activada con exito, !Bienvenido al equipo de Game Store!';
                }
                else {
                    $message ='Valio chostomo la activación de la cuenta :(';
                }
            }
        }
        else{
            $message ='No hay registro relacionado para hacer activación';
        }
        return $message;
    }

    #Actualizamos la base de datos para confirmar la activacion de la cuenta de usuario
    function activaUsuario($id){
        global $DB_conection;
        $consulta = $DB_conection->prepare('UPDATE usuarios SET Activacion =1 WHERE Id_empleado =?');
        $consulta->bind_param('s', $id);
        $ejecutar = $consulta->execute();
        $consulta-> close();
        return $ejecutar;
    }

    #FUNCIONES PARA EL INICIO DE SESION
    #Se checa que los campos no esten vacios
    function checkInfoLogin($usuario, $password){
        if(strlen(trim($usuario)) <1 || strlen(trim($password)) <1){
            return true;
        }
        else{
            return false;
        }
    }

    #Comprobamos que los datos enviados se encuentren registrados en la DB
    #Si el usuario existe iniciamos sesion y lo redireccionamos a la pagina del portal
    function loginUser($usuario, $password){
        global $DB_conection;
        $consulta = $DB_conection->prepare("SELECT 	Id_empleado, Permisos, Pass FROM usuarios WHERE Email = ? LIMIT 1");
        $consulta ->bind_param("s", $usuario);
        $consulta ->execute();
        $consulta->store_result();
        $fila = $consulta->num_rows;

        if($fila > 0){
            if(cuentaActiva ($usuario)){
                $consulta->bind_result($idU, $permiso, $passDB);
                $consulta->fetch();
                $checkPass = password_verify($password, $passDB);

                if($checkPass){
                    lastSesion($idU);
                    //Actualizar estado online-hacer funcion de estado online
                    userOnline($idU);
                    $_SESSION['id_usuario'] = $idU;
                    $_SESSION['permisos'] = $permiso;
                    header("location: portal.php");
                }
                else{
                    $errores ='Contraseña incorrecta';
                }
            } 
            else {
                $errores = 'Esta cuenta todavía no ha sido activada';
            }
        }
        else{
            $errores = 'El E-mail no esta asociado a ningun usuario';
        }
        return $errores;
    }

    #Verificamos que la cuenta que esta iniciando sesion ya se encuentre activada
    function cuentaActiva($usuario){
        global $DB_conection;
        $consulta = $DB_conection->prepare("SELECT Activacion FROM usuarios WHERE Email= ? LIMIT 1");
        $consulta ->bind_param('s', $usuario);
        $consulta->execute();
        $consulta->bind_result($activacion);
        $consulta->fetch();

        if($activacion == 1){
            return true;
        }
        else{
            return false;
        }
    }

    #Ultima sesion
    function lastSesion($idU){
        global $DB_conection;
        $consulta = $DB_conection->prepare("UPDATE usuarios SET Ultima_sesion=NOW(), Token_pass='', Pedir_pass=1 WHERE Id_empleado = ?");
        $consulta->bind_param('s', $idU);
        $consulta->execute();
        $consulta->close();
    }

    #Funciones para reestablecer contraseña y esta es olvidada
    function obtenerValor($campo, $campoReferencia, $valor){
        global $DB_conection;
        $consulta = $DB_conection->prepare("SELECT $campo FROM usuarios WHERE $campoReferencia=? LIMIT 1");
        $consulta->bind_param('s', $valor);
        $consulta->execute();
        $consulta->store_result();
        $fila = $consulta->num_rows;

        if($fila > 0){
            $consulta->bind_result($campo);
            $consulta->fetch();
            return $campo;
        }
        else{

        }
    }

    #Comparamos el token de usuario de la DB y comprobar que el usuario ha solicitado recuperar contraseña
    function creaTokenPass($userId){
        global $DB_conection;
        $token = creaToken();
        $consulta = $DB_conection->prepare("UPDATE usuarios SET Token_pass=?, Pedir_pass=1 WHERE Id_empleado=?");
        $consulta->bind_param('ss', $token, $userId);
        $consulta->execute();
        $consulta->close();
        return $token;
    }
    #Se verifica que realmente el usuario haya solicitado una recuperacion del password
    function validarTokenPass($userId, $token) {
        global $DB_conection;
        $consulta= $DB_conection->prepare("SELECT Activacion FROM usuarios WHERE Id_empleado=? AND Token_pass=? AND Pedir_pass=1 LIMIT 1");
        $consulta->bind_param('is', $userId, $token);
        $consulta->execute();
        $consulta->store_result();
        $fila = $consulta->num_rows;

        if($fila >0){
            $consulta->bind_result($activacion);
            $consulta->fetch();
            if($activacion == 1){
                return true;
            }
            else{
                return false;
            }
        }
    }

    #Se genera el nuevo password y se guarda en la DB
    function nuevoPass($pass1, $userId, $token){
        global $DB_conection;
        $consulta = $DB_conection->prepare("UPDATE usuarios SET Pass = ?, Token_pass='', Pedir_pass=0 WHERE Id_empleado=? AND Token_pass=?");
        $consulta ->bind_param('sis', $pass1, $userId, $token);
        if($consulta->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    #Funciones para controlar si el usuario esta online o no
    #funcion online
    function userOnline($idUser){
        global $DB_conection;
        $consulta = $DB_conection->prepare("UPDATE usuarios SET Estado=1 WHERE Id_empleado = ?");
        $consulta->bind_param('s', $idUser);
        $consulta->execute();
        $consulta->close();
    }

    #funcion outline
    function userOutline($idUser){
        global $DB_conection;
        $consulta = $DB_conection->prepare("UPDATE usuarios SET Estado=0 WHERE Id_empleado = ?");
        $consulta->bind_param('s', $idUser);
        $consulta->execute();
        $consulta->close();
    }

    #Funcion para subir Archivo 
    function uploadDoc($varArchivo, $varExtension, $varSize, $varRuta, $idUser){
        global $DB_conection;
        $sqlUpload = $DB_conection->prepare("INSERT INTO formatos (Documento, Extension, Size, Ruta, Upload_by) VALUES (?, ?, ?, ?, ?)");
        $sqlUpload->bind_param('ssisi', $varArchivo, $varExtension, $varSize, $varRuta, $idUser);
        if($sqlUpload->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }

    #Funcion para subir Foto de archivo
    function uploadAvatar($varFoto, $idUser){
        global $DB_conection;
        $sqlUpload = $DB_conection->prepare("UPDATE usuarios SET Foto=? WHERE Id_empleado= ?");
        $sqlUpload->bind_param('si', $varFoto, $idUser);
        $sqlUpload->execute();
        $sqlUpload->close();
    }

    #Funciones para el cambio de password desde la pg de configuracion
    #Funcion para no enviar campos Vacios
    function checkInputPass($passNuevo01, $passNuevo02, $passActual){
        if(strlen(trim($passNuevo01)) <1 || strlen(trim($passNuevo02)) <1 || strlen(trim($passActual)) <1){
            return true;
        }
        else{
            return false;
        }
    }
    #Funcion para comparar que la contraseña actual de usuario coincida con la registrada enb la base de datos
    function checkPassActual($idUser, $password){
        global $DB_conection;
        $consulta = $DB_conection->prepare("SELECT 	Id_empleado, Pass FROM usuarios WHERE Id_empleado = ? LIMIT 1");
        $consulta ->bind_param("i", $idUser);
        $consulta ->execute();
        $consulta->store_result();
        $fila = $consulta->num_rows;

        if($fila > 0){
            $consulta->bind_result($idU, $passDB);
            $consulta->fetch();
            $checkPass = password_verify($password, $passDB);

            if($checkPass){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $errores = 'No hay información relacionada al usuario solicitado';
        }
        return $errores;
    }
    #Funcion Actualizar Password
    function refreshPass($newPass, $idUser){
        global $DB_conection;
        $sqlPass = $DB_conection->prepare("UPDATE usuarios SET Pass=? WHERE Id_empleado= ?");
        $sqlPass->bind_param('si', $newPass, $idUser);
        $sqlPass->execute();
        $sqlPass->close();
    }
    #Funcion para agregar cliente nuevo
    function addCliente($varNombre, $varRepresentante, $varTel, $varDireccion, $varMail, $varRFC, $varFoto){
        global $DB_conection;
        $sqlCliente = $DB_conection->prepare("INSERT INTO clientes (Nombre, Representante, Telefono, Direccion, Email, RFC, Foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sqlCliente->bind_param('sssssss', $varNombre, $varRepresentante, $varTel, $varDireccion, $varMail, $varRFC, $varFoto);
        if($sqlCliente->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }
    #Funcion para editar cliente nuevo
    function editCliente($varNombre, $varRepresentante, $varTel, $varDireccion, $varMail, $varRFC, $varFoto, $idCliente){
        global $DB_conection;
        $sqlCliente = $DB_conection->prepare("UPDATE clientes SET Nombre=?, Representante=?, Telefono=?, Direccion=?, Email=?, RFC=?, Foto=? WHERE Id_cliente= ?");
        $sqlCliente->bind_param('sssssssi', $varNombre, $varRepresentante, $varTel, $varDireccion, $varMail, $varRFC, $varFoto, $idCliente);
        $sqlCliente->execute();
        $sqlCliente->close();     
    }

    #Funcion para agregar producto nuevo
    function addProducto($varProducto, $varPiezas, $varMarca, $varPrecio, $varCategoria, $varFoto, $varDescripcion){
        global $DB_conection;
        $sqlProducto = $DB_conection->prepare("INSERT INTO productos (Producto, Num_piezas, Marca, Precio, Categoria, Foto, Descripcion) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sqlProducto->bind_param('sisisss', $varProducto, $varPiezas, $varMarca, $varPrecio, $varCategoria, $varFoto, $varDescripcion);
        if($sqlProducto->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }

    #Funcion para editar producto
    function editProducto($varProducto, $varPiezas, $varMarca, $varPrecio, $varCategoria, $varFoto, $varDescripcion, $idProducto){
        global $DB_conection;
        $sqlProducto = $DB_conection->prepare("UPDATE productos SET Producto=?, Num_piezas=?, Marca=?, Precio=?, Categoria=?, Foto=?, Descripcion=? WHERE Id_producto= ?");
        $sqlProducto->bind_param('sisisssi', $varProducto, $varPiezas, $varMarca, $varPrecio, $varCategoria, $varFoto, $varDescripcion, $idProducto);
        $sqlProducto->execute();
        $sqlProducto->close();    
    }

    #Funcion para agregar proveedor nuevo
    function addProveedor($varEmpresa, $varTel, $varDireccion, $varCP, $varRFC, $varFoto, $varMail){
        global $DB_conection;
        $sqlProveedor = $DB_conection->prepare("INSERT INTO proveedores (Nombre_empresa, Telefono, Direccion, CP, RFC, Foto, Email) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sqlProveedor->bind_param('sssisss', $varEmpresa, $varTel, $varDireccion, $varCP, $varRFC, $varFoto, $varMail);
        if($sqlProveedor->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }

    #Funcion para editar proveedor
    function editProveedor($varEmpresa, $varTel, $varDir, $varCP, $varRFC, $varFoto, $varMail, $idProveedor){
        global $DB_conection;
        $sqlProveedor = $DB_conection->prepare("UPDATE proveedores SET Nombre_empresa=?, Telefono=?, Direccion=?, CP=?, RFC=?, Foto=?, Email=? WHERE Id_proveedor= ?");
        $sqlProveedor->bind_param('sssisssi', $varEmpresa, $varTel, $varDir, $varCP, $varRFC, $varFoto, $varMail, $idProveedor);
        $sqlProveedor->execute();
        $sqlProveedor->close();        
    }

    #Funcion para editar usuario
    function editUser($varNom, $varApellidoP, $varApellidoM, $varFechaNac, $varRFC, $varSexo, $varCalle, $varCol, $varCP, $varEntidad, $varTel, $varSuc, $varTurno, $varDepto, $varMail, $varPermisos, $varFoto, $idUser){
        global $DB_conection;
        $sqlUser = $DB_conection->prepare("UPDATE usuarios SET Nombre=?, Apellido_p=?, Apellido_m=?, Fecha_nac=?, RFC=?, Sexo=?, Calle=?, Colonia=?, CP=?, Entidad=?, Telefono=?, Sucursal=?, Turno=?, Departamento=?, Email=?, Permisos=?, Foto=? WHERE Id_empleado= ?");
        $sqlUser->bind_param('ssssssssissssssisi', $varNom, $varApellidoP, $varApellidoM, $varFechaNac, $varRFC, $varSexo, $varCalle, $varCol, $varCP, $varEntidad, $varTel, $varSuc, $varTurno, $varDepto, $varMail, $varPermisos, $varFoto, $idUser);
        $sqlUser->execute();
        $sqlUser->close();   
    }
    #Funcion para el formulario de agregar cliente y que no se envien campos vacios
    function checarCliente($varNombre, $varRepresentante, $varTel, $varDir, $varMail, $varRFC){
        if(strlen(trim($varNombre)) <1 || strlen(trim($varRepresentante)) <1 || strlen(trim($varTel)) <1 || strlen(trim($varDir)) <1 || strlen(trim($varTel)) <1 || strlen(trim($varRFC)) <1){
            return true;            
        }
        else {
            return false;
        }
    }
    #Funcion para el formulario de agregar producto y que no se envien campos vacios
    function checarProducto($varProducto, $varPiezas, $varMarca, $varPrecio, $varCategoria, $varDescripcion){
        if(strlen(trim($varProducto)) <1 || strlen(trim($varPiezas)) <1 || strlen(trim($varMarca)) <1 || strlen(trim($varPrecio)) <1 || strlen(trim($varCategoria)) <1 || strlen(trim($varDescripcion)) <1){
            return true;            
        }
        else {
            return false;
        }
    }
    #Funcion para el formulario de agregar proveedor y que no se envien campos vacios
    function checarProveedor($varNombre, $varTel, $varDireccion, $varCP, $varRFC, $varMail){
        if(strlen(trim($varNombre)) <1 || strlen(trim($varTel)) <1 || strlen(trim($varDireccion)) <1 || strlen(trim($varCP)) <1 || strlen(trim($varRFC)) <1 || strlen(trim($varMail)) <1){
            return true;            
        }
        else {
            return false;
        }
    }
    #Funcion para el formulario de editar empleado y que no se envien campos vacios
    function checarEmpleado($varNombre, $varApellido_p, $varApellido_m, $varFecha_nac, $varRFC, $varSexo, $varCalle, $varCol, $varCP, $varEntidad, $varTel, $varSucursal, $varTurno, $varDepto, $varCorreo, $varPermisos){
        if(strlen(trim($varNombre)) <1 || strlen(trim($varApellido_p)) <1 || strlen(trim($varApellido_m)) <1 || strlen(trim($varFecha_nac)) <1 || strlen(trim($varRFC)) <1 || strlen(trim($varSexo)) <1 || strlen(trim($varCalle)) <1 || strlen(trim($varCol)) <1 || strlen(trim($varCP)) <1 || strlen(trim($varEntidad)) <1 || strlen(trim($varTel)) <1 || strlen(trim($varSucursal)) <1 || strlen(trim($varTurno)) <1 || strlen(trim($varDepto)) <1 || strlen(trim($varCorreo)) <1 || strlen(trim($varPermisos)) <1 ){
            return true;            
        }
        else {
            return false;
        }
    }
?>
