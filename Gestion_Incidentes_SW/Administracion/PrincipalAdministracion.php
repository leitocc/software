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
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
    </head>
    <body id="top">
        <?php include_once '../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../menu.php'; ?>

                <div class="main">
                    <div class="post">
                        <div style="clear: both">
                            <?php
                            $msj = filter_input(INPUT_GET, "msj");
                            if (isset($msj)) {
                                switch ($msj) {
                                    case 1:
                                        echo '<div class="msj_ok">Se grabó correctamente</div>';
                                        break;
                                    case 2:
                                        echo '<div class="msj_error">Se produjo un error al grabar</div>';
                                        break;
                                    default:
                                        break;
                                }
                            }
                            ?>
                            <li class="no_lista"><h2>Administración</h2></li>
                            <li class="no_lista"><h3><a href="Componente/RegistrarComponente.php">Registrar Componente</a></h3></li>
                            <li class="no_lista"><h3><a href="Componente/ModificarComponente.php">Modificar Componente</a></h3></li>
                            <li class="no_lista"><h3><a href="Componente/cargaComponenteXAula.php">Agregar Componente a Aula</a></h3></li>
                            <li class="no_lista"><h3><a href="Componente/EliminarComponenteXAula.php">Quitar Componente a aula</a></h3></li>
                        </div>
                    </div>
                </div>
                <?php include_once './../foot.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php
if (isset($_SESSION['mensaje'])) {
    unset($_SESSION['mensaje']);
}