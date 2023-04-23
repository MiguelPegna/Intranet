<?php
    #FUNCIONES PARA EL ENVIO DE MENSAJES PRIVADOS
    #REvisamos que los datos del  formulario esten completos
    function revCampos($varPara, $varAsunto, $varMensaje){
        if(strlen(trim($varPara)) <1 || strlen(trim($varAsunto)) <1 || strlen(trim($varMensaje)) <1){
            return true;            
        }
        else {
            return false;
        }
    }

    #Se ejecuta la funcion para ingresar el mensaje en la base de datos
    function enviarMensaje($idUser, $cambio, $varAsunto, $varMensaje){
        global $DB_conection;

        $consulta = $DB_conection->prepare('INSERT INTO mensajes (De, Para, Asunto, Mensaje) VALUES (?, ?, ?, ?)');
        $consulta->bind_param('iiss', $idUser, $cambio, $varAsunto, $varMensaje);
        if($consulta->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
        }       
    }

    #Verificamos que el usuario a quien se le va amandar el mensaje exista en la base de datos
    function encontrarUsuario($varPara){
        global $DB_conection;
        $consulta = $DB_conection->prepare('SELECT Id_empleado, Nombre, Apellido_p, Departamento FROM usuarios WHERE Nombre = ? LIMIT 1');
        $consulta ->bind_param("s", $varPara);
        $consulta ->execute();
        $consulta->store_result();
        $fila = $consulta->num_rows;

        if($fila >0){
            return true;
        }
        else{
            return false;
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

    #Funciones para el control del buzón de sugerencias
    #funcion que revisa que no haya campos Vacios
    function revInputs($varAsunto, $varSugerencia){
        if(strlen(trim($varAsunto)) <1 || strlen(trim($varSugerencia)) <1){
            return true;            
        }
        else {
            return false;
        }
    }
    
    #Función para mandar email de sugerencias
    function enviarMail($varCorreo, $asunto, $mensaje){
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        try{
            $correo="vectormirror@gmail.com";
            $pass="xcvbnm4321";
            $myHost="smtp.gmail.com";
            $puerto= "587";
            $deParte="NoReply-Buzon de sugerencias";
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

            $mail->addAddress($varCorreo);
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


?>