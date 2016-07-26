<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
include_once '../limpiarSesion.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Incidentes</title>
        <link rel="stylesheet" type="text/css" href="/IncidentesSoftware/css/estilo.css" />
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery-1.11.1.js"></script>
        <?php 
        //echo "Pruebo y .. ";
        if(isset($_REQUEST['mjs']) && $_REQUEST['mjs'] != ''){
            //echo "Entro, ";
            $codigo = $_REQUEST['mjs'];
            //echo "codigo: ".$codigo;
            switch($codigo){
                case 0:{
                    $msj = "Error. Operación fallida";
                    break;
                }
                case 1:{
                    $msj = "Operación realizada con éxito";
                    break;
                }
                default :{
                    $msj = "";
                    break;
                }
            }
            //echo "msj: ".$msj;
            if($msj != ""){
            ?>
            <script>
                $(document).ready(function() {
                    alert("<?php echo $msj?>");
                });
            </script>
            <?php
            }
        }
        ?>
    </head>
    <body id="top">
        <?php include_once '../master.php';?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../menu.php';?>
                
                <div class="main">
                    <div class="post">
                        <div style="clear: both">
                            <li class="no_lista"><h2>Incidentes</h2></li>
                            <li class="no_lista"><h3><a href="RegistrarIncidente.php">Registrar Nuevo Incidente</a></h3></li>
                            <li class="no_lista"><h3><a href="BuscarIncidente.php">Buscar Incidentes</a></h3></li>
                        </div>
                    </div>
                </div>
                <?php include_once './../foot.php';?>
            </div>
        </div>
    </body>
</html>