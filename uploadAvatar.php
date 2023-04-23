<?php    
    session_start();
    require 'includes/DB_conexion.php';
    require 'includes/funciones.php';

    $idUser = $_SESSION['id_usuario'];
    $accesos= $_SESSION['permisos'];
    $_FILES['imagen'];

    if($_FILES['imagen']['error']>0 ){
        echo "<script>alert('ERROR No seleccionaste ningún archivo HDPM >:( '); </script>";
        echo "<script>setTimeout(\"location.href='config.php'\",500); </script>";
    }
    else {
        $varExtension = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
        $varKb=500;
        $varSize= $varKb *1024;  #pasamos el valor de la varKb a KB
        #Se verifica que el archivo que se esta subiendo tiene extensión aceptada y no sobrepasa el tamaño definido 
        if(in_array($_FILES['imagen']['type'], $varExtension) && $_FILES['imagen']['size']<= $varSize){
            $varDir='avatar/' .$idUser .'/';
            $varRuta= $varDir.$_FILES['imagen']['name'];
            #Si no existe el directorio lo crea
            if(!file_exists($varDir)){
                mkdir($varDir);
            }
            #If para evitar archivos duplicados
            if(!file_exists($varRuta)){
                $varFoto= @move_uploaded_file($_FILES['imagen']['tmp_name'], $varRuta);
                #insertamos la información en la tabla llamando nuestra funcion 
                uploadAvatar($varRuta, $idUser);

                #if donde se cumplen las condiciones para subir el documento
                if($varFoto){
                    echo "<script>alert('¡Tu foto de perfil se ha actualizado con éxito :)!'); </script>";
                    echo "<script>setTimeout(\"location.href='config.php'\",500); </script>";  
                }
                else{
                    echo "<script>alert('¡Tu foto de perfil no se pudo cambiar!'); </script>";
                    echo "<script>setTimeout(\"location.href='config.php'\",500); </script>";  
                }

            }
            else{
                echo "<script>alert('El Archivo ya existe'); </script>";
                echo "<script>setTimeout(\"location.href='config.php'\",500); </script>";
            }
        }
        else{
            echo "<script>alert('Extensión de archivo no permitida o excede 5Mb'); </script>";
            echo "<script>setTimeout(\"location.href='config.php'\",500); </script>";
        }
    }
?>