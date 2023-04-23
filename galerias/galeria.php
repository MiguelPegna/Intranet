<?php
    #script de validacion de datos para registro de usuarios
    session_start();
    require '../includes/DB_conexion.php';
    require '../includes/funciones.php';
    #require 'includes/posting.php';

    if(!isset($_SESSION['id_usuario'])){
        header('Location: index.php');
    }

    $idUser = $_SESSION['id_usuario'];
    $accesos= $_SESSION['permisos'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/Inicio.css">
    <link rel="stylesheet" href="../css/mensajes.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>.:Galerias || Game Store:.</title>
</head>
<body>
    <header>

        <?php include_once 'header.php';?>

    </header>

    <main class="contenedor main">
        <div class="portada">
           
        </div>
        <div class="servicios">
            <?php
               if (isset($_GET['album']))
                  $album = $_GET['album'];
               else
                  $album = "";
               // Properties
               $headline = "Galerias || Game Store";
               $subheadline = "Galería de eventos de Game Store";
               $showroomwidth = 500;
               $showdesc = 1;
               // Headline
               print("<div align=center><font size=\"+2\"><b>$headline</b></a></font>
                  <br><font size=2>$subheadline</font><br><br>");
               // Index
               if ($album == "" && $filehandle = opendir("."))
               {
                  print("<table class='table table-sm table-hover'><tr><td width=$showroomwidth><p class=navigation>&nbsp;Navegación:&nbsp;&nbsp;
                     <a href=\"galeria.php\"><b>Indíce de galerías</b></a></p></td></tr></table><table>");
                  while (false !== ($albumcheck = readdir($filehandle)))
                  {
                     if ($albumcheck != "." && $albumcheck != ".." && is_dir($albumcheck) && substr($albumcheck,0,1) != "_")
                     {
                        $albums[] = $albumcheck;
                     }
                  }
                  closedir($filehandle);
                  natcasesort($albums);
                  foreach ($albums as $album)
                  {
                     if (file_exists("./$album/info.txt"))
                        include("./$album/info.txt");
                     else
                     {
                        $albumname = $album;
                        $albuminfo = "";
                     }
                     print ("<tr><td width=$showroomwidth>");
                     if (file_exists("./$album/thumbnail.jpg"))
                        print ("<a href=\"galeria.php?album=$album\"><img border=1 class=albumtn src=\"$album/thumbnail.jpg\" width='50' height='50'></a>");
                     print ("<p class=albuminfo><a href=\"galeria.php?album=$album\"><b>$albumname</b></a>");
                     print ("<br>$albuminfo");
                     print ("</p></td></tr>");
                  }
                  print("</table>");
               }
               // Creating the albums
               else
               {
                  if(is_dir($album))
                  {
                     if (file_exists("./$album/info.txt"))
                     {
                        include("./$album/info.txt");
                     }
                     else
                     {
                        $albumname = $album;
                        $albuminfo = "";
                     }

                     if (isset($_GET['show']))
                        $show = $_GET['show'];
                     else
                        $show = 1;
                     $img_dir = "./$album";
                     $dir = opendir($img_dir);
                     $thumbstring = "|";

                  // Reading and checking images in the folder of the album
                     while ($file = readdir($dir))
                     {
                        if ($file != "." && $file != ".." && $file != "thumbnail.jpg")
                        {
                        $extension = substr($file, -4);
                  if(($extension == ".JPG") || ($extension == ".jpg"))
                           $thumbstring .= "$file|";
                        }
                     }
                     $thumbstring = trim($thumbstring, "|");
                     $arry_txt = explode("|" , $thumbstring);
                     (array)$temparray = null;
                     natcasesort($arry_txt);
                     $arry_txt = array_merge((array)$temparray, $arry_txt);
                     if ($show > (sizeof($arry_txt)) || $show == "")
                        $show = 1;
                     if ($show < 1)
                     $show = sizeof($arry_txt);
                     $img = "" . $arry_txt[$show - 1] . "";
                  // Setting the beginning and the end of the album
                     if ($show == 0)
                        $back = "<td width=75><font size=0><a href=\"galeria.php?album=$album&amp;show=" . (sizeof($arry_txt) - 1) . "\">&laquo; Anterior</a></font>";
                     else
                        $back = "<td width=75><font size=0><a href=\"galeria.php?album=$album&amp;show=" . ($show - 1) . "\">&laquo; Anterior</a></font>";
                     if ($show == sizeof($arry_txt) - 1)
                        $forward = "<td width=75><font size=0><a title=forward href=\"galeria.php?album=$album&amp;show=1\"> Siguiente &raquo; </a></font>";
                     else
                        $forward = "<td width=75><font size=0><a title=forward href=\"galeria.php?album=$album&amp;show=" . ($show + 1) . "\">Siguiente &raquo;</a></font>";

                  // Reading the images' width and adjusting the size of a cell
                     $imgsize = (getimagesize(rtrim($album . "/" . $img)));
                     $midtdsize = ($imgsize[0] - 162);
                     if ($midtdsize < 370)   $midtdsize = 370;
                     print("<table class='table table-sm table-hover'><tr><td colspan=3 width=" . ($midtdsize + 162) . "><p class=navigation>&nbsp;Navegación:&nbsp;
                           <a href=\"galeria.php\">Galerías</a> > <a href=\"galeria.php?album=$album\"><b>$albumname</b></a></p>
                           </td></tr></table>");
                     print("<table class='linktd table table-sm table-hover'><tr>");
                     print($back);
                     print("</td><td width=\"" . $midtdsize . "\"><font size=\"0\"><b>");
                     print("Imagen " . ($show) . " de " . (sizeof($arry_txt)));
                     print("</b></font></td>");
                     print($forward);
                     print("</td></tr></table><table><tr>");
                     print("<td colspan=3><a title=\"forward\" href=\"galeria.php?album=$album&amp;show=" . ($show + 1) . "\"><img border=0 src=\"" . $img_dir . "/" . $img . "\" width='930' height='auto'></a></td>");
                     print("</tr>");
                     print("</table><table class=\"linktd\"><tr>");
                     if($showdesc == 1)
                        print("<td width=$imgsize[0] colspan=3><font size=1><b>Nombre:</b> '" . $img . "'&nbsp;&nbsp;&nbsp;<b>Peso:</b> " . (round((filesize($img_dir . "/" . $img)/1024), 1)) . " KB &nbsp;&nbsp;&nbsp;<b>Dimensiones:</b> " . $imgsize[0] . "x" . $imgsize[1] . " px</font></td></tr>");

                     $imginfo = substr($img, 0, -4) . '_info';

                     if (isset($$imginfo) && $$imginfo != "")
                        print("<td width=$imgsize[0] colspan=3><font size=1><b>Image description:</b> " . $$imginfo . "</font></td></tr>");

                     print($back);
                     print("</td><td width=" . $midtdsize . "><font size=0><b>");
                     print("Imagen " . ($show) . " de " . (sizeof($arry_txt)));
                     print("</b></font></td>");
                     print($forward);
                     print("</td></tr>");

                  // Preview
                     print("<tr><td colspan=3 valign=top height=116><div align=center><table class='table table-sm table-hover'><tr>");
                     if (($show - 3) > 0)
                        print("<td class=prevbtn><a href=\"galeria.php?album=$album&amp;show=" . ($show - 4) . "\"><br><<br><br><br><<br></a></td>");
                     else  print("<td class=prevbtn>&nbsp;</td>");

                     for ($i = -2; $i < 3; $i++)
                     {
                        if (!isset($arry_txt[$show + $i - 1]) || $arry_txt[$show + $i - 1] == null)
                           $link = "&nbsp;";
                        else
                        {
                           $imgsize = getimagesize(rtrim($album . "/" . ($arry_txt[$show + $i - 1])));
                           if (($imgsize[0]) > ($imgsize[1]))
                              $img  = "<img border=1 width=85 src=\"" . $img_dir . "/" . ($arry_txt[$show + $i - 1]) . "\">";
                           else
                              $img  = "<img border=1 height=80 src=\"" . $img_dir . "/" . ($arry_txt[$show + $i - 1]) . "\">";
                           if ($i == 0)
                              $link = "<a href=\"galeria.php?album=$album&amp;show=" . ($show) . "\">Actual<br>$img</a>";
                           else
                              $link = "<a href=\"galeria.php?album=$album&amp;show=" . ($show + $i) . "\">" . ($show + $i) . "/" . (sizeof($arry_txt)) . "<br>$img</a>";
                        }
                        print("<td class=previmg>");
                        print($link);
                        print("</td>");
                     }

                     if (($show + 4) < sizeof($arry_txt))
                        print("<td class=prevbtn><a href=\"galeria.php?album=$album&amp;show=" . ($show + 4) . "\"><br>><br><br><br>><br></a></td>");
                     else
                        print("<td class=prevbtn>&nbsp;</td>");
                     print("</tr></table></div></td></tr></table>");
                  }
               }
            ?>        
        </div>
      <?php include_once '../footer.html';?>
    </main>
</body>
</html>