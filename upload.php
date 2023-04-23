<?php    
    session_start();
    require 'includes/DB_conexion.php';
    require 'includes/funciones.php';

    $idUser = $_SESSION['id_usuario'];
    $accesos= $_SESSION['permisos'];
    $_FILES['archivo'];
    //Unidades de peso de archivo
    $TB = pow(1024, 4);
    $GB = pow(1024, 3);
    $MB = pow(1024, 2);

    if($_FILES['archivo']['error']>0 ){
        echo "<script>alert('ERROR No seleccionaste ningún archivo HDPM >:( '); </script>";
        echo "<script>setTimeout(\"location.href='formatos.php'\",500); </script>";
    }
    else {
        $varExtension = array('image/png', 'image/jpeg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation');
        $varSize= $MB *5;  #seleccionamos el limite que queremos que pasen los archivos que se suben
        #Se verifica que el archivo que se esta subiendo tiene extensión aceptada y no sobrepasa el tamaño definido 
        if(in_array($_FILES['archivo']['type'], $varExtension) && $_FILES['archivo']['size']<= $varSize){
            $varDir='formatos';
            $varRuta= $varDir .'/'. $_FILES['archivo']['name'];
            #Si no existe el directorio lo crea
            if(!file_exists($varDir)){
                mkdir($varDir);
            }
            #If para evitar archivos duplicados
            if(!file_exists($varRuta)){
                $varDocumento= @move_uploaded_file($_FILES['archivo']['tmp_name'], $varRuta);
                #insertamos la información en la tabla llamando nuestra funcion 
                uploadDoc($_FILES['archivo']['name'], pathinfo($varRuta, PATHINFO_EXTENSION), $_FILES['archivo']['size'], $varRuta, $idUser);

                #if donde se cumplen las condiciones para subir el documento
                if($varDocumento){
                    echo "<script>alert('¡El documento se ha subido con éxito :)!'); </script>";
                    echo "<script>setTimeout(\"location.href='formatos.php'\",500); </script>";  
                }
                else{
                    echo "<script>alert('¡El documento no se pudo subir!'); </script>";
                    echo "<script>setTimeout(\"location.href='formatos.php'\",500); </script>";  
                }

            }
            else{
                echo "<script>alert('El Archivo ya existe'); </script>";
                echo "<script>setTimeout(\"location.href='formatos.php'\",500); </script>";
            }
        }
        else{
            echo "<script>alert('Extensión de archivo no permitida o excede 5Mb'); </script>";
            echo "<script>setTimeout(\"location.href='formatos.php'\",500); </script>";
        }
    }
?>