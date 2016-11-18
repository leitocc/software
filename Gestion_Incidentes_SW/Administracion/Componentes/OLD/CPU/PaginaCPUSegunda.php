<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../../../verificarPermisos.php';
require_once '../../../Conexion.php';
if (isset($_POST['si'])) {
    $_SESSION['si'] = $_POST['si'];
}
$SI = $_SESSION['si'];
$consulta = mysql_query("SELECT id_componente AS id FROM componente "
        . "where id_tipo_componente = 4 and baja = 0 and id_sistema_informatico=" . $SI);
if ($row = mysql_fetch_row($consulta)) {
    $componente = $row[0];
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistemas Informaticos - Agregar componentes de CPU </title>
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
                $("#agregarPlacaM").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaMadre/PaginaPlacaMadre.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarPlacaM").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaMadre/PaginaPlacaMadre.php?modo=mod';
                });

                $("#quitarPlacaM").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar la Placa Madre del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaMadre/Placa.php?modo=del';
                    }
                });

                $("#agregarPlacaA").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaAudio/PaginaPlacaAudio.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarPlacaA").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaAudio/PaginaPlacaAudio.php?modo=mod';
                });

                $("#quitarPlacaA").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar la Placa de Audio del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaAudio/PlacaAudio.php?modo=del';
                    }
                });

                $("#agregarPlacaV").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaVideo/PaginaPlacaVideo.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarPlacaV").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaVideo/PaginaPlacaVideo.php?modo=mod';
                });

                $("#quitarPlacaV").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar la Placa de Video del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaVideo/PlacaVideo.php?modo=del';
                    }
                });

                $("#agregarPlacaR").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaRed/PaginaPlacaRed.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarPlacaR").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaRed/PaginaPlacaRed.php?modo=mod';
                });

                $("#quitarPlacaR").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar la Placa de Red del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/PlacaRed/PlacaRed.php?modo=del';
                    }
                });
<?php /*
  //                $("#agregarDisco1").click(function(mievento){
  //                    mievento.preventDefault();
  //                    var tipoDisco = $("#tipoComponenteDisco").val();
  //                    var direccion = "/incidentes/Componentes/Generico/ComponenteGenerico.php?modo=ins&idSub=<?php echo $componente ?>&tipoComponente=" + tipoDisco + "&idTipoComponente=" + $("#idTipoComponenteDisco").val();
  //                    alert(tipoDisco + " - " + direccion);
  //                    window.location = direccion;
  //                });
  //
  //                $("#modificarDisco1").click(function(mievento){
  //                    mievento.preventDefault();
  //                    var direccion = "/incidentes/Componentes/Generico/ComponenteGenerico.php?modo=mod&tipoComponente=" + $("#tipoComponenteDisco").val() + "&idTipoComponente=" + $("#idTipoComponenteDisco").val() + "&idComponente=" + $("#idComponenteDisco1").val() ;
  //                    alert(direccion);
  //                    window.location = direccion;
  //                });
  //
  //                $("#quitarDisco1").click(function(mievento){
  //                    mievento.preventDefault();
  //                    if(confirm("¿Está seguro que desea quitar el Disco Rigido del SI <?php echo $SI ?>?")){
  //                        var direccion = '/incidentes/Componentes/Generico/ComponenteGenerico.php?modo=del' + $("#idComponenteDisco").val() + '';
  //                        window.location = direccion;
  //                    }
  //                });
  //                $("#agregarDisco2").click(function(mievento){
  //                    mievento.preventDefault();
  //                    var tipoDisco = $("#tipoComponenteDisco").val();
  //                    var direccion = "/incidentes/Componentes/Generico/ComponenteGenerico.php?modo=ins&idSub=<?php echo $componente ?>&tipoComponente=" + tipoDisco + "&idTipoComponente=" + $("#idTipoComponenteDisco").val();
  //                    alert(tipoDisco + " - " + direccion);
  //                    window.location = direccion;
  //                });
  //
  //                $("#modificarDisco2").click(function(mievento){
  //                    mievento.preventDefault();
  //                    var direccion = "/incidentes/Componentes/Generico/ComponenteGenerico.php?modo=mod&tipoComponente=" + $("#tipoComponenteDisco").val() + "&idTipoComponente=" + $("#idTipoComponenteDisco").val() + "&idComponente=" + $("#idComponenteDisco2").val() ;
  //                    window.location = direccion;
  //                });
  //
  //                $("#quitarDisco2").click(function(mievento){
  //                    mievento.preventDefault();
  //                    if(confirm("¿Está seguro que desea quitar el Disco Rigido del SI <?php echo $SI ?>?")){
  //                        var direccion = '/incidentes/Componentes/Generico/ComponenteGenerico.php?modo=del' + $("#idComponenteDisco").val() + '';
  //                        window.location = direccion;
  //                    }
  //                }); */ ?>
                $("#agregarDisco1").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/DiscoDuro1/PaginaDiscoDuro.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarDisco1").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/DiscoDuro1/PaginaDiscoDuro.php?modo=mod&idComponente=' + $("#idComponenteDisco1").val();
                });

                $("#quitarDisco1").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar el Disco Rigido del SI ?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/DiscoDuro1/DiscoDuro.php?modo=del&idComponente=' + $("#idComponenteDisco1").val();
                    }
                });
                $("#agregarDisco2").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/DiscoDuro2/PaginaDiscoDuro.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarDisco2").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/DiscoDuro2/PaginaDiscoDuro.php?modo=mod&idComponente=' + $("#idComponenteDisco2").val();
                });

                $("#quitarDisco2").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar el Disco Rigido del SI ?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/DiscoDuro2/DiscoDuro.php?modo=del&idComponente=' + $("#idComponenteDisco2").val();
                    }
                });

                $("#agregarMemoria1").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam1/PaginaMemoriaRam.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarMemoria1").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam1/PaginaMemoriaRam.php?modo=mod&idComponente=' + $("#idComponenteRam1").val();
                });

                $("#quitarMemoria1").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar la Memoria RAM del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam1/Memoria.php?modo=del&idComponente=' + $("#idComponenteRam1").val();
                    }
                });
                $("#agregarMemoria2").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam2/PaginaMemoriaRam.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarMemoria2").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam2/PaginaMemoriaRam.php?modo=mod&idComponente=' + $("#idComponenteRam2").val();
                });

                $("#quitarMemoria2").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar la Memoria RAM del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam2/Memoria.php?modo=del&idComponente=' + $("#idComponenteRam2").val();
                    }
                });
                $("#agregarMemoria3").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam3/PaginaMemoriaRam.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarMemoria3").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam3/PaginaMemoriaRam.php?modo=mod&idComponente=' + $("#idComponenteRam3").val();
                });

                $("#quitarMemoria3").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar la Memoria RAM del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam3/Memoria.php?modo=del&idComponente=' + $("#idComponenteRam3").val();
                    }
                });
                $("#agregarMemoria4").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam4/PaginaMemoriaRam.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarMemoria4").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam4/PaginaMemoriaRam.php?modo=mod&idComponente=' + $("#idComponenteRam4").val();
                });

                $("#quitarMemoria4").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar la Memoria RAM del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/MemoriaRam4/Memoria.php?modo=del&idComponente=' + $("#idComponenteRam4").val();
                    }
                });

                $("#agregarProcesador").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Microprocesador/PaginaProcesador.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarProcesador").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Microprocesador/PaginaProcesador.php?modo=mod';
                });

                $("#quitarProcesador").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar el Microprocesador del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Microprocesador/Procesador.php?modo=del';
                    }
                });

                $("#agregarLectora").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Lectora/PaginaLectora.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarLectora").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Lectora/PaginaLectora.php?modo=mod';
                });

                $("#quitarLectora").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar la Lectora del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Lectora/Lectora.php?modo=del';
                    }
                });

                $("#agregarFuente").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Fuente/PaginaFuente.php?modo=ins&idSub=<?php echo $componente ?>';
                });

                $("#modificarFuente").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Fuente/PaginaFuente.php?modo=mod';
                });

                $("#quitarFuente").click(function (mievento) {
                    mievento.preventDefault();
                    if (confirm("¿Está seguro que desea quitar la Fuente del SI <?php echo $SI ?>?")) {
                        window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/Fuente/Fuente.php?modo=del';
                    }
                });

                $("#Volver").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/Componentes/ModificarComponentesSI.php';
                });
            });
        </script>
    </head>
    <body id="top">
        <?php include_once '../../../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../../../menu.php'; ?>

                <div class="main">
                    <div class="post">
                        <li class="no_lista"><h2>Componentes de CPU del Sistema Informático <?php echo $SI ?></h2></li>
                        <li class="no_lista">
                            <div style="width: 100px; float: left"><label>Placa Madre</label></div>
                            <?php
                            $consultaPlacaM = "SELECT M.descripcion AS marca, C.descripcion AS modelo
                FROM componente C join marca M on (M.id_marca=C.id_marca)
                WHERE C.id_tipo_componente = 7 AND C.id_sistema_informatico = " . $SI . " AND C.baja =0";
                            $query1 = mysql_query($consultaPlacaM);

                            if (mysql_num_rows($query1) === 0) {
                                $PlacaM = "No asignado";
                                $nuevo = true;
                            } else {
                                $nuevo = false;
                                while ($row = mysql_fetch_array($query1)) {
                                    $PlacaM = $row['marca'] . ", " . $row['modelo'];
                                }
                            }
                            ?>
                            <input type="text" readonly="true" value="<?php echo $PlacaM ?>"/>
                            <?php if ($nuevo) { ?>
                                <button class="submit" name="agregarPlacaM" id="agregarPlacaM">Agregar</button>
                            <?php } else { ?>
                                <button class="modificar" name="modificarPlacaM" id="modificarPlacaM">Modificar</button>
                                <button class="quitar" name="quitarPlacaM" id="quitarPlacaM">Quitar</button>
                            <?php } ?>
                        </li>
                        <li class="no_lista">
                            <div style="width: 100px; float: left"><label>Placa Audio:</label></div>
                            <?php
                            $consultaPlacaA = "SELECT M.descripcion AS marca, C.descripcion AS modelo
                FROM componente C join marca M on (M.id_marca=C.id_marca)
                WHERE C.id_tipo_componente = 10
                AND C.id_sistema_informatico = " . $SI . " AND C.baja =0";
                            $query1 = mysql_query($consultaPlacaA);

                            if (mysql_num_rows($query1) === 0) {
                                $PlacaA = "No asignado";
                                $nuevo = true;
                            } else {
                                $nuevo = false;
                                while ($row = mysql_fetch_array($query1)) {
                                    $PlacaA = $row['marca'] . ", " . $row['modelo'];
                                }
                            }
                            ?>
                            <input type="text" readonly="true" value="<?php echo $PlacaA ?>"/>
                            <?php if ($nuevo) { ?>
                                <button class="submit" name="agregarPlacaA" id="agregarPlacaA">Agregar</button>
                            <?php } else { ?>
                                <button class="modificar" name="modificarPlacaA" id="modificarPlacaA">Modificar</button>
                                <button class="quitar" name="quitarPlacaA" id="quitarPlacaA">Quitar</button>
<?php } ?>
                        </li>
                        <li class="no_lista">
                            <div style="width: 100px; float: left"><label>Placa Video:</label></div>
<?php
$consultaPlacaV = "SELECT M.descripcion AS marca, C.descripcion AS modelo
                FROM componente C join marca M on (M.id_marca=C.id_marca)
                WHERE C.id_tipo_componente = 8 AND C.id_sistema_informatico = " . $SI . " AND C.baja =0";
$query1 = mysql_query($consultaPlacaV);

if (mysql_num_rows($query1) === 0) {
    $PlacaV = "No asignado";
    $nuevo = true;
} else {
    $nuevo = false;
    while ($row = mysql_fetch_array($query1)) {
        $PlacaV = $row['marca'] . ", " . $row['modelo'];
    }
}
?>
                            <input type="text" readonly="true" value="<?php echo $PlacaV ?>"/>
                            <?php if ($nuevo) { ?>
                                <button class="submit" name="agregarPlacaV" id="agregarPlacaV">Agregar</button>
                            <?php } else { ?>
                                <button class="modificar" name="modificarPlacaV" id="modificarPlacaV">Modificar</button>
                                <button class="quitar" name="quitarPlacaV" id="quitarPlacaV">Quitar</button>
                            <?php } ?>
                        </li>
                        <li class="no_lista">
                            <div style="width: 100px; float: left"><label>Placa Red:</label></div>
<?php
$consultaPlacaR = "SELECT M.descripcion AS marca, C.descripcion AS modelo
                FROM componente C join marca M on (M.id_marca=C.id_marca)
                WHERE C.id_tipo_componente = 9
                AND C.id_sistema_informatico = " . $SI . " AND C.baja =0";
$query1 = mysql_query($consultaPlacaR);

if (mysql_num_rows($query1) === 0) {
    $PlacaR = "No asignado";
    $nuevo = true;
} else {
    $nuevo = false;
    while ($row = mysql_fetch_array($query1)) {
        $PlacaR = $row['marca'] . ", " . $row['modelo'];
    }
}
?>
                            <input type="text" readonly="true" value="<?php echo $PlacaR ?>"/>
                            <?php if ($nuevo) { ?>
                                <button class="submit" name="agregarPlacaR" id="agregarPlacaR">Agregar</button>
                            <?php } else { ?>
                                <button class="modificar" name="modificarPlacaR" id="modificarPlacaR">Modificar</button>
                                <button class="quitar" name="quitarPlacaR" id="quitarPlacaR">Quitar</button>
                            <?php } ?>
                        </li>

                        <!-- AQUI VAN LOS DISCOS DUROS-->
                            <?php
                            $consultaDisco = "SELECT M.descripcion AS marca, C.descripcion AS modelo, 
                C.id_componente, C.id_tipo_componente 
                FROM componente C join marca M on (M.id_marca=C.id_marca)
                WHERE C.id_tipo_componente = 6
                AND C.id_sistema_informatico = " . $SI . " AND C.baja =0";
                            $query1 = mysql_query($consultaDisco);
                            $cantFilas = mysql_num_rows($query1);
                            if ($cantFilas === 0) {
                                $Disco = "No asignado";
                                //$nuevo = true;
                                ?>
                            <li class="no_lista">
                                <div style="width: 100px; float: left"><label>Disco Duro nro. 1:</label></div>
                                <input type="text" readonly="true" value="<?php echo $Disco ?>"/>
                                <button class="submit" name="agregarDisco1" id="agregarDisco1">Agregar</button>

                            </li>
                            <li class="no_lista">
                                <div style="width: 100px; float: left"><label>Disco Duro nro. 2:</label></div>
                                <input type="text" readonly="true" value="<?php echo $Disco ?>"/>
                                <button class="submit" name="agregarDisco2" id="agregarDisco2">Agregar</button>
                            </li>
    <?php
} else {
    //$nuevo=false;
    $index = 1;
    while ($row = mysql_fetch_array($query1)) {
        $Disco = $row['marca'] . ", " . $row['modelo'];
        ?>
                                <li class="no_lista">
                                    <div style="width: 100px; float: left"><label>Disco Duro nro. <?php echo $index ?>:</label></div>
                                    <input type="text" readonly="true" value="<?php echo $Disco ?>"/>
                                    <button class="modificar" name="modificarDisco<?php echo $index ?>" id="modificarDisco<?php echo $index ?>">Modificar</button>
                                    <button class="quitar" name="quitarDisco<?php echo $index ?>" id="quitarDisco<?php echo $index ?>">Quitar</button>
                                    <input type="hidden" id="idComponenteDisco<?php echo $index ?>" value="<?php echo $row['id_componente'] ?>"/>
                                </li>

        <?php
        $index++;
    }
    if ($cantFilas != 2) {
        ?>
                                <li class="no_lista">
                                    <div style="width: 100px; float: left"><label>Disco Duro nro. <?php echo $index ?>:</label></div>
                                    <input type="text" readonly="true" value="No asignado"/>
                                    <button class="submit" name="agregarDisco2" id="agregarDisco2">Agregar</button>
                                </li>
        <?php
    }
}
?>
                        <input type="hidden" id="tipoComponenteDisco" value="Disco Duro"/>
                        <input type="hidden" id="idTipoComponenteDisco" value="6"/>




                        <!-- AQUI VAN LAS RAM-->
<?php
$consultaMemoria = "SELECT M.descripcion AS marca, C.descripcion AS modelo, C.id_componente
                FROM componente C join marca M on (M.id_marca=C.id_marca)
                WHERE C.id_tipo_componente = 5
                AND C.id_sistema_informatico = " . $SI . " AND C.baja =0";
$query1 = mysql_query($consultaMemoria);
$cantFilas = mysql_num_rows($query1);
if ($cantFilas === 0) {
    $Memoria = "No asignado";
//            $nuevo = true;
    ?>
                            <li class="no_lista">
                                <div style="width: 100px; float: left"><label>Memoria Ram nro. 1:</label></div>
                                <input type="text" readonly="true" value="<?php echo $Memoria ?>"/>
                                <button class="submit" name="agregarMemoria1" id="agregarMemoria1">Agregar</button>
                            </li>
                            <li class="no_lista">
                                <div style="width: 100px; float: left"><label>Memoria Ram nro. 2:</label></div>
                                <input type="text" readonly="true" value="<?php echo $Memoria ?>"/>
                                <button class="submit" name="agregarMemoria2" id="agregarMemoria2">Agregar</button>
                            </li>
                            <li class="no_lista">
                                <div style="width: 100px; float: left"><label>Memoria Ram nro. 3:</label></div>
                                <input type="text" readonly="true" value="<?php echo $Memoria ?>"/>
                                <button class="submit" name="agregarMemoria3" id="agregarMemoria4">Agregar</button>
                            </li>
                            <li class="no_lista">
                                <div style="width: 100px; float: left"><label>Memoria Ram nro. 4:</label></div>
                                <input type="text" readonly="true" value="<?php echo $Memoria ?>"/>
                                <button class="submit" name="agregarMemoria4" id="agregarMemoria4">Agregar</button>
                            </li>


    <?php
} else {
    $index = 1;
    $nuevo = false;
    while ($row = mysql_fetch_array($query1)) {
        $Memoria = $row['marca'] . ", " . $row['modelo'];
        //echo $Memoria;
        ?>
                                <li class="no_lista">
                                    <div style="width: 100px; float: left"><label>Memoria Ram nro. <?php echo $index ?>:</label></div>
                                    <input type="text" readonly="true" value="<?php echo $Memoria ?>"/>
                                    <button class="modificar" id="modificarMemoria<?php echo $index ?>">Modificar</button>
                                    <button class="quitar" id="quitarMemoria<?php echo $index ?>">Quitar</button>
                                    <input type="hidden" id="idComponenteRam<?php echo $index ?>" value="<?php echo $row['id_componente'] ?>"/>
                                </li>

        <?php
        $index++;
    }
    $cantFaltante = 4 - $cantFilas;
    while ($cantFaltante != 0) {
        ?>
                                <li class="no_lista">
                                    <div style="width: 100px; float: left"><label>Memoria Ram nro. <?php echo $index ?>:</label></div>
                                    <input type="text" readonly="true" value="No asignado"/>
                                    <button class="submit" id="agregarMemoria<?php echo $index ?>">Agregar</button>
                                </li>

        <?php
        $cantFaltante--;
        $index++;
    }
}
?>







                        <li class="no_lista">
                            <div style="width: 100px; float: left"><label>Microprocesador:</label></div>
<?php
$consultaProcesador = "SELECT M.descripcion AS marca, C.descripcion AS modelo
                FROM componente C join marca M on (M.id_marca=C.id_marca)
                WHERE C.id_tipo_componente = 13
                AND C.id_sistema_informatico = " . $SI . " AND C.baja =0";
$query1 = mysql_query($consultaProcesador);

if (mysql_num_rows($query1) === 0) {
    $Procesador = "No asignado";
    $nuevo = true;
} else {
    $nuevo = false;
    while ($row = mysql_fetch_array($query1)) {
        $Procesador = $row['marca'] . ", " . $row['modelo'];
    }
}
?>
                            <input type="text" readonly="true" value="<?php echo $Procesador ?>"/>
                            <?php if ($nuevo) { ?>
                                <button class="submit" name="agregarProcesador" id="agregarProcesador">Agregar</button>
                            <?php } else { ?>
                                <button class="modificar" name="modificarProcesador" id="modificarProcesador">Modificar</button>
                                <button class="quitar" name="quitarProcesador" id="quitarProcesador">Quitar</button>
                            <?php } ?>
                        </li>
                        <li class="no_lista">
                            <div style="width: 100px; float: left"><label>Lectora:</label></div>
                            <?php
                            $consultaLectora = "SELECT M.descripcion AS marca, C.descripcion AS modelo
                FROM componente C join marca M on (M.id_marca=C.id_marca)
                WHERE C.id_tipo_componente = 11
                AND C.id_sistema_informatico = " . $SI . " AND C.baja =0";
                            $query1 = mysql_query($consultaLectora);

                            if (mysql_num_rows($query1) === 0) {
                                $Lectora = "No asignado";
                                $nuevo = true;
                            } else {
                                $nuevo = false;
                                while ($row = mysql_fetch_array($query1)) {
                                    $Lectora = $row['marca'] . ", " . $row['modelo'];
                                }
                            }
                            ?>
                            <input type="text" readonly="true" value="<?php echo $Lectora ?>"/>
                            <?php if ($nuevo) { ?>
                                <button class="submit" name="agregarLectora" id="agregarLectora">Agregar</button>
                            <?php } else { ?>
                                <button class="modificar" name="modificarLectora" id="modificarLectora">Modificar</button>
                                <button class="quitar" name="quitarLectora" id="quitarLectora">Quitar</button>
                            <?php } ?>
                        </li>
                        <li class="no_lista">
                            <div style="width: 100px; float: left"><label>Fuente:</label></div>
                            <?php
                            $consultaFuente = "SELECT M.descripcion AS marca, C.descripcion AS modelo
                FROM componente C join marca M on (M.id_marca=C.id_marca)
                WHERE C.id_tipo_componente = 14
                AND C.id_sistema_informatico = " . $SI . " AND C.baja = 0";
                            $query1 = mysql_query($consultaFuente);

                            if (mysql_num_rows($query1) === 0) {
                                $Fuente = "No asignado";
                                $nuevo = true;
                            } else {
                                $nuevo = false;
                                while ($row = mysql_fetch_array($query1)) {
                                    $Fuente = $row['marca'] . ", " . $row['modelo'];
                                }
                            }
                            ?>
                            <input type="text" readonly="true" value="<?php echo $Fuente ?>"/>
                            <?php if ($nuevo) { ?>
                                <button class="submit" name="agregarFuente" id="agregarFuente">Agregar</button>
                            <?php } else { ?>
                                <button class="modificar" name="modificarFuente" id="modificarFuente">Modificar</button>
                                <button class="quitar" name="quitarFuente" id="quitarFuente">Quitar</button>
                            <?php } ?>
                        </li>
                        <li class="no_lista">
                            <button class="submit" name="Volver" id="Volver">Volver</button>
                        </li>
                    </div>
                </div>
<?php include_once '../../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php if (isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); ?>
