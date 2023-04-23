<?php
    #FUNCIONES PARA EL ENVIO DE MENSAJES PRIVADOS
    #REvisamos que los datos del  formulario esten completos
    function revCampos($varTitulo, $varDescripcion, $varMensaje){
        if(strlen(trim($varTitulo)) <1 || strlen(trim($varDescripcion)) <1 || strlen(trim($varMensaje)) <1){
            return true;            
        }
        else {
            return false;
        }
    }

    #Se ejecuta la funcion para ingresar el mensaje en la base de datos
    function enviarPost($varTitulo, $varDescripcion, $varMensaje, $varAutor){
        global $DB_conection;

        $consulta = $DB_conection->prepare('INSERT INTO anuncios (Titulo, Descripcion, Anuncio, Autor) VALUES (?, ?, ?, ?)');
        $consulta->bind_param('sssi', $varTitulo, $varDescripcion, $varMensaje, $varAutor);
        if($consulta->execute()){
            return $DB_conection->insert_id;
        }
        else{
            return 0;
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

    #Funcion para editar anuncio
    function editProducto($varTitulo, $varDescripcion, $varAnuncio, $varAutor, $idAnuncio){
        global $DB_conection;
        $sqlProducto = $DB_conection->prepare("UPDATE anuncios SET Titulo=?, Descripcion=?, Anuncio=? WHERE Id_anuncio= ?");
        $sqlProducto->bind_param('sssii', $varTitulo, $varDescripcion, $varAnuncio, $varAutor, $idAnuncio);
        $sqlProducto->execute();
        $sqlProducto->close();    
    }

?>