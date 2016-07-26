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
        <title>Sistemas Informaticos</title>
        <link rel="stylesheet" type="text/css" href="/IncidentesSoftware/css/estilo.css" />
        <?php 
            if(isset($_SESSION['mensaje'])){      
                $mensaje = $_SESSION['mensaje'];
            }else {
                $mensaje = "";
            }
        ?>
        <script>
            $(document).ready(function() {
                var mensaje = "<?php echo $mensaje?>";
                if (mensaje !== "") {
                    alert(mensaje);
                }
            });
        </script>
    </head>
    <body id="top">
        <?php include_once '../master.php';?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../menu.php';?>
                
                <div class="main">
                    <div class="post">
                        <div style="clear: both">
                            <li class="no_lista"><h2>Administración</h2></li>
                            <li class="no_lista"><h3><a href="Componente/RegistrarComponente.php">Registrar Componente</a></h3></li>
                            <li class="no_lista"><h3><a href="Componente/BajaComponente.php">Dar Baja Componente</a></h3></li>
                            <li class="no_lista"><h3><a href="Componente/cargaComponenteXAula.php">Carga Componente por Aula</a></h3></li>
                        </div>
                    </div>
                </div>
                <?php include_once './../foot.php';?>
            </div>
        </div>
    </body>
</html>
<?php
if (isset($_SESSION['mensaje'])) {
    unset($_SESSION['mensaje']);
}