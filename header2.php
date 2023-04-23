<?php
    #Consultas a la db
    #Consulta info usuarios
    $sqlSearch="SELECT Id_empleado, Nombre, Apellido_p, Apellido_m, Foto, Turno, Departamento, Sucursal, Permisos Estado FROM usuarios WHERE Id_empleado='$idUser' LIMIT 1";
    $resultado = $DB_conection->query($sqlSearch);
    $imprimir = $resultado->fetch_assoc();

    #Consulta de mensajes
    $sqlMsg="SELECT COUNT(*) Leido FROM mensajes WHERE Para='$idUser' AND Leido=1 ";
    $inbox = $DB_conection->query($sqlMsg);
    $verInbox = $inbox->fetch_assoc();
?>
 <style>
        .notif{
            background-color: rgba(255,51,51,.5 );
            color: #fff;
            font-size: 2.5rem;
            width: 25px;
            height: 25px;
            position: absolute;
            right: 32rem;
            top: 3rem;
            justify-content: center;
        }
        .num{
            position: absolute;
            right: .6rem;
            top: -.5rem;
        }
    </style>
<div class="contenedor InicioC">
    <div class="header1">
        <div class="online">
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

        

        <div class="conjunto1">
            <div class="conjunto2"> 
                <?php if($accesos==1 or $accesos==2){ ?>
                <div class="online">
                    <a href="crear_cuenta.php" title="Registrar nuevo usuario">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="9" cy="7" r="4" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 11h6m-3 -3v6" />
                        </svg>
                        
                    </a>
                </div>
                <?php } ?>

                <?php if($accesos==1 or $accesos==2 or $accesos==3){ ?>
                <div class="online">
                    <a href="nuevo-post.php" title="Crear Anuncio">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-template" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <rect x="4" y="4" width="16" height="4" rx="1" />
                        <rect x="4" y="12" width="6" height="8" rx="1" />
                        <line x1="14" y1="12" x2="20" y2="12" />
                        <line x1="14" y1="16" x2="20" y2="16" />
                        <line x1="14" y1="20" x2="20" y2="20" />
                        </svg>
                    </a>
                </div>
                <?php } ?>

            </div>
            <div class="conjunto3">
                <div class="online">
                    <a href="formatos.php" title="Formatos">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                        <line x1="9" y1="7" x2="13" y2="7" />
                        <line x1="9" y1="11" x2="13" y2="11" />
                        </svg>
                    </a>
                </div>
                <div class="online">
                    <a href="buzon.php" title="Buzón">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mailbox" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 21v-6.5a3.5 3.5 0 0 0 -7 0v6.5h18v-6a4 4 0 0 0 -4 -4h-10.5" />
                        <path d="M12 11v-8h4l2 2l-2 2h-4" />
                        <path d="M6 15h1" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="online">
    <!--Total de notificaciones poner formato al numero-->    
    <?php if($verInbox['Leido']>= 1){ ?>   
        <div class="notif"><label class="num"><?php echo $verInbox['Leido']; ?></label></div>
    <?php } ?>
        <a href="inbox.php" title="mensajes">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-messages" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
            <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
            </svg>
        </a>

        <a href="config.php?id=<?php echo $idUser ?>" title="Configuracion">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
            <circle cx="12" cy="12" r="3" />
            </svg>
        </a>                
        
    </div>

            
    <div class="usuario">
        <a href="user.php?id=<?php echo $idUser ?>">
        <img src="<?php echo $imprimir['Foto']; ?>" title="<?php echo $imprimir['Nombre']. " " .$imprimir['Apellido_p']?>" width="42" heigth="42" style="border-radius:50%"> <!--style="border-radius:50%"> -->
            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <circle cx="12" cy="7" r="4" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
            </svg> -->
        </a>    
    
        <a href="includes/logout.php" title="Cerrar Sesión">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
            <path d="M7 12h14l-3 -3m0 6l3 -3" />
            </svg>
        </a>
    </div>
</div>