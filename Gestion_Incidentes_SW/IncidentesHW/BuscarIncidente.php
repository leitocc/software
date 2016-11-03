<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
require_once '../Conexion.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Buscar Incidentes</title>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery.datetimepicker.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery.datepicker-es.js"></script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/tabla.css" />
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/jquery.datetimepicker.css" />
        <script>
            function irDetalle(id) {
                window.location = 'DetalleIncidente.php?id=' + id;
            }
            $(document).ready(function () {
                $("#sala").change(function (e) {
                    if ($("#sala").val() !== "") {
                        $.ajax({
                            url: "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/SistemaInformatico/cargarSI.php",
                            type: "POST",
                            data: "sala=" + $("#sala").val(),
                            success: function (opciones) {
                                $("#si").html(opciones).show("slow");
                            }
                        });
                    } else {
                        $("#si").html("<option>Seleccione...</option>")
                    }
                });
                $("#desde").datepicker({
                    dateFormat: 'dd/mm/yy',
                    maxDate: "+0D",
                    defaultDate: "-2w",
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 2,
                    onClose: function (selectedDate) {
                        $("#hasta").datepicker("option", "minDate", selectedDate);
                    }
                });
                $("#hasta").datepicker({
                    dateFormat: 'dd/mm/yy',
                    maxDate: "+0D",
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 2,
                    onClose: function (selectedDate) {
                        if (selectedDate !== "") {
                            $("#desde").datepicker("option", "maxDate", selectedDate);
                        } else {
                            $("#desde").datepicker("option", "maxDate", "+0D");
                        }
                    }
                });
                $("#buscar").click(function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/IncidentesHW/ajax/buscarIncidente.php",
                        type: "POST",
                        data: "estado=" + $("#estado").val() + "&desde=" + $("#desde").val()
                                + "&hasta=" + $("#hasta").val() + "&sala=" + $("#sala").val()
                                + "&si=" + $("#si").val(),
                        success: function (opciones) {
                            $("#resultadoBusqueda").html(opciones).show("slow");
                        }
                    });
                });
            });
        </script>
    </head>
    <body id="top">
        <?php include_once '../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../menu.php'; ?>

                <div class="main">
                    <div class="post">
                        <li class="no_lista"><h2>Buscar incidentes</h2></li>
                        <h4>Elegir parametros de busqueda</h4>
                        <div class="archive-separator"></div>
                        <table>
                            <tr>
                                <td>
                                    <label for="estado">Estado:</label>
                                </td>
                                <td colspan="3">
                                    <select id="estado">
                                        <option>Todos</option>
                                        <?php
                                        $consultaEstado = "SELECT E.nombre_estado AS nombre, E.id_estado AS id
                                            FROM estado E";
                                        $query1 = mysql_query($consultaEstado);
                                        if (mysql_errno() == 0) {
                                            while ($row = mysql_fetch_array($query1)) {
                                                ?>
                                                <option value ="<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></option>
                                            <?php }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="sala">Sala:</label>
                                </td>
                                <td>
                                        <?php $consulta = mysql_query("select * from sala"); ?>
                                    <select name="sala" id="sala">
                                        <option value="">Seleccione...</option>
                                        <?php while ($row = mysql_fetch_array($consulta)) { ?>
                                            <option value ="<?php echo $row['id_sala'] ?>"><?php echo $row['nombre'] ?></option>
<?php } ?>
                                    </select>
                                </td>
                                <td>
                                    <label for="si">Identificaci&oacute;n:</label>
                                </td>
                                <td>
                                    <select name="si" id="si">
                                        <option value="">Seleccione...</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="desde">Fecha desde:</label>
                                </td>
                                <td>
                                    <input id="desde">
                                </td>
                                <td>
                                    <label for="hasta">Fecha hasta:</label>
                                </td>
                                <td>
                                    <input id="hasta">
                                </td>
                            </tr>
                        </table>
                        <div align="center"><button class="submit" id="buscar">Buscar</button></div>
                        <div class="archive-separator"></div>
                        <div id="resultadoBusqueda"></div>

                    </div>
                </div>
<?php include_once './../foot.php'; ?>
            </div>
        </div>
    </body>
</html>
