<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../../verificarPermisos.php';
if (isset($_REQUEST['idIncidente'])) {
    $_SESSION['idIncidente'] = $_REQUEST['idIncidente'];
}
if (isset($_REQUEST['si'])) {
    $_SESSION['si'] = $_REQUEST['si'];
}
$SI = $_SESSION['si'];
require_once '../../Conexion.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistemas Informaticos - Modificar Componentes</title>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <?php
        if (isset($_SESSION['mensaje'])) {
            $mensaje = $_SESSION['mensaje'];
        } else {
            $mensaje = "";
        }
        ?>
        <script>
            $(document).ready(function () {
                var mensaje = "<?php echo $mensaje ?>";
                if (mensaje !== "") {
                    alert(mensaje);
                }
                $("#volver").click(function (mievento) {
                    mievento.preventDefault();
                    //history.back();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/ModificarSisitemaInformatico.php';
                });
<?php if (isset($_SESSION['idIncidente'])) { ?>
                    $("#volverIncidentes").click(function (mievento) {
                        mievento.preventDefault();
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Incidentes/DetalleIncidente.php?id=<?php echo $_SESSION['idIncidente'] ?>';
                    });
<?php } ?>
                $("#agregarMonitor").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Monitor/PaginaMonitor.php?modo=ins';
                });

                $("#modificarMonitor").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Monitor/PaginaMonitor.php?modo=mod';
                });

                $("#quitarMonitor").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Esta seguro que desea quitar el Monitor del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Monitor/Monitor.php?modo=del';
                    }
                });

                $("#agregarMouse").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Mouse/PaginaMouse.php?modo=ins';
                });

                $("#modificarMouse").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Mouse/PaginaMouse.php?modo=mod';
                });

                $("#quitarMouse").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Esta seguro que desea quitar el Mouse del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Mouse/Mouse.php?modo=del';
                    }
                });

                $("#agregarTeclado").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Teclado/PaginaTeclado.php?modo=ins';
                });

                $("#modificarTeclado").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Teclado/PaginaTeclado.php?modo=mod';
                });

                $("#quitarTeclado").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar el Teclado del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Teclado/Teclado.php?modo=del';
                    }
                });
                $("#agregarCpu").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/CPU/PaginaCPU.php?modo=ins';
                });

                $("#modificarCpu").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/CPU/PaginaCPU.php?modo=mod';
                });

                $("#quitarCpu").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar el CPU del SI <?php echo $SI ?> con todos sus componentes internos?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/CPU/CpuPrimero.php?modo=del';
                    }
                });

                $("#agregarDetalle").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/CPU/PaginaCPUSegunda.php';
                });
            });
        </script>
    </head>
    <body id="top">
        <?php include_once '../../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../../menu.php'; ?>

                <div class="main">
                    <div class="post">

                        <li class="no_lista"><h2>Componentes del Sistema Informático <?php echo $SI ?></h2></li>
                        <li class="no_lista">
                            <div style="width: 60px; float: left"><label for="monitor">Monitor:</label></div>
                            <?php
                            $consultaMonitor = "SELECT M.descripcion AS marca, C.descripcion AS modelo
                                FROM componente C join marca M on (M.id_marca=C.id_marca)
                                WHERE C.id_tipo_componente = 1 and C.baja =0
                                AND C.id_sistema_informatico = " . $SI;
                            $query1 = mysql_query($consultaMonitor);

                            if (mysql_num_rows($query1) === 0) {
                                $monitor = "No asignado";
                                $nuevo = true;
                            } else {
                                $nuevo = false;
                                while ($row = mysql_fetch_array($query1)) {
                                    $monitor = $row['marca'] . ", " . $row['modelo'];
                                }
                            }
                            ?>
                            <input id="monitor" type="text" readonly="true" value="<?php echo $monitor ?>"/>
                            <?php if ($nuevo) { ?>
                                <button class="submit" name="agregarMonitor" id="agregarMonitor">Agregar</button>
                            <?php } else { ?>
                                <button class="modificar" name="modificarMonitor" id="modificarMonitor">Modificar</button>
                                <button class="quitar" name="quitarMonitor" id="quitarMonitor">Quitar</button>
                            <?php } ?>
                        </li>
                        <li class="no_lista">
                            <div style="width: 60px; float: left"><label for="mouse">Mouse:</label></div>
                            <?php
                            $consultaMouse = "SELECT M.descripcion AS marca, C.descripcion AS modelo
                                FROM componente C join marca M on (M.id_marca=C.id_marca)
                                WHERE C.id_tipo_componente = 2 and C.baja=0
                                AND C.id_sistema_informatico = " . $SI;
                            $query1 = mysql_query($consultaMouse);

                            if (mysql_num_rows($query1) === 0) {
                                $mouse = "No asignado";
                                $nuevo = true;
                            } else {
                                $nuevo = false;
                                while ($row = mysql_fetch_array($query1)) {
                                    $mouse = $row['marca'] . ", " . $row['modelo'];
                                }
                            }
                            ?>
                            <input id="mouse" type="text" readonly="true" value="<?php echo $mouse ?>"/>
                            <?php if ($nuevo) { ?>
                                <button class="submit" name="agregarMouse" id="agregarMouse">Agregar</button>
                            <?php } else { ?>
                                <button class="modificar" name="modificarMouse" id="modificarMouse">Modificar</button>
                                <button class="quitar" name="quitarMouse" id="quitarMouse">Quitar</button>
                            <?php } ?>

                        </li>
                        <li class="no_lista">
                            <div style="width: 60px; float: left"><label for="teclado">Teclado:</label></div>
<?php
$consultaTeclado = "SELECT M.descripcion AS marca, C.descripcion AS modelo
                                FROM componente C join marca M on (M.id_marca=C.id_marca)
                                WHERE C.id_tipo_componente = 3 and C.baja=0
                                AND C.id_sistema_informatico = " . $SI;
$query1 = mysql_query($consultaTeclado);
if (mysql_num_rows($query1) === 0) {
    $teclado = "No asignado";
    $nuevo = true;
} else {
    $nuevo = false;
    while ($row = mysql_fetch_array($query1)) {
        $teclado = $row['marca'] . ", " . $row['modelo'];
    }
}
?>
                            <input id="teclado" type="text" readonly="true" value="<?php echo $teclado ?>"/>
                            <?php if ($nuevo) { ?>
                                <button class="submit" name="agregarTeclado" id="agregarTeclado">Agregar</button>
                            <?php } else { ?>
                                <button class="modificar" name="modificarTeclado" id="modificarTeclado">Modificar</button>
                                <button class="quitar" name="quitarTeclado" id="quitarTeclado">Quitar</button>
                            <?php } ?>
                        </li>
                        <li class="no_lista">
                            <div style="width: 60px; float: left"><label for="cpu">CPU:</label></div>
                            <?php
                            $consultaTeclado = "SELECT M.descripcion AS marca, C.descripcion AS modelo
                                FROM componente C join marca M on (M.id_marca=C.id_marca)
                                WHERE C.id_tipo_componente = 4 and C.baja = 0
                                AND C.id_sistema_informatico = " . $SI;
                            $query1 = mysql_query($consultaTeclado);
                            if (mysql_num_rows($query1) === 0) {
                                $cpu = "No asignado";
                                $nuevo = true;
                            } else {
                                $nuevo = false;
                                while ($row = mysql_fetch_array($query1)) {
                                    $cpu = $row['marca'] . ", " . $row['modelo'];
                                }
                            }
                            ?>
                            <input id="cpu" type="text" readonly="true" value="<?php echo $cpu ?>"/></td>
                        <td>
                            <?php if ($nuevo) { ?>
                                <button class="submit" name="agregarCpu" id="agregarCpu">Agregar</button>
                            <?php } else { ?>
                                <button class="modificar" name="modificarCpu" id="modificarCpu">Modificar</button>
                                <button class="quitar" name="quitarCpu" id="quitarCpu">Quitar</button>
                                <button class="submit" name="agregarDetalle" id="agregarDetalle">Agregar Detalle</button>
                            <?php } ?>
                            </li>
                        <li class="no_lista">
<?php if (!isset($_SESSION['idIncidente'])) { ?>
                                <button class="submit" name="volver" id="volver">Volver</button>
                            <?php } else { ?>
                                <button class="submit" name="incidentes" id="volverIncidentes">Volver a Intervención</button>
                            <?php } ?>
                        </li>
                    </div>
                </div>
                            <?php include_once '../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>
                <?php
                if (isset($_SESSION['mensaje'])) {
                    unset($_SESSION['mensaje']);
                }
