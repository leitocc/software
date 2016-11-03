<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';

$si = filter_input(INPUT_POST, "si");

require_once '../Conexion2.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SGI-HW - Reportes</title>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css"/>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/ajax.js"></script>
        <script type="text/javascript">
            function crea_query_string() {
                var idTipoComponente = document.getElementById("tipoComponente");
                return "idTipoComponente=" + encodeURIComponent(idTipoComponente.value) +
                        "&si=" + encodeURIComponent(<?php echo $si ?>) +
                        "&nocache=" + Math.random();
            }

            function procesaRespuesta() {
                if (peticion_http.readyState == READY_STATE_COMPLETE) {
                    if (peticion_http.status == 200) {
                        document.getElementById("datos").innerHTML = peticion_http.responseText;
                    }
                }
            }
            window.onload = function () {
                document.getElementById("tipoComponente").onchange = function (e) {
                    var tipoComponente = document.getElementById("tipoComponente").value;
                    if (tipoComponente !== "") {
                        valida("/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Reportes/ajax/listarIncidentesPorComponente.php");
                    } else {
                        alert("Ingrese un tipo de componente");
                    }
                };
            };
        </script>
    </head>
    <body id="top">
        <?php include_once '../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../menu.php'; ?>

                <div class="main">
                    <div class="post">
                        <form name="formulario" id="formulario" action="InicioReportes.php" method="post" class="contact_form">
                            <?php ?>
                            <li><h2>Reporte de incidentes por componente afectado</h2></li>
                            <li><h3>Incidentes que afectaron el Sistema Informatico: <?php echo $si ?></h3></li>
                            <li><h4>Seleccione componente afectado:</h4></li>
                            <div>
                                <table>
                                    <tr>
                                        <td>Componente:</td>
                                        <td>
                                            <?php
                                            $query = "select * from tipo_componente";
                                            $resultado = $mysqli->query($query);
                                            $aux = "<select name='tipoComponente' id='tipoComponente'>";
                                            $aux.= "<option value=''>Seleccione...</option>";
                                            print($aux);
                                            while ($row = $resultado->fetch_assoc()) {
                                                $aux = "<option value =" . $row['id_tipo_componente'] . " >";
                                                $aux.= $row['descripcion'] . "</option>";
                                                print($aux);
                                                $aux = "";
                                            }
                                            print '</select>';
                                            $resultado->free();
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                                <div id="datos"></div>
                                <li>
                                    <button class="submit" name="Submit" id="Volver">Volver</button>
                                </li>
                            </div>
                        </form>
                    </div>
                </div>
                <?php include_once '../foot.php'; ?>
            </div>
        </div>
    </body>
</html>