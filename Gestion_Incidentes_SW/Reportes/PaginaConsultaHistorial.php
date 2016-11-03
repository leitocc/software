<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
require_once '../Conexion2.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SGI-HW - Reportes</title>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery.validate.js"></script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/tabla.css" />
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/jquery-ui.css" />
        <script>
            function validarCampos() {
                if ($("#sala").val() !== "") {
                    if ($("#si").val() !== "") {
                        if ($("#tipo").val() !== "") {
                            return true;
                        } else {
                            alert("Seleccione un componente para realizar la busqueda");
                        }
                    } else {
                        alert("Seleccione un SI para realizar la busqueda");
                    }
                } else {
                    alert("Seleccione una sala para realizar la busqueda");
                }
                return false;
            }
            ;
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
                $("#Volver").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = 'InicioReportes.php';
                });
                $("#buscar").click(function (e) {
                    e.preventDefault();
                    if (validarCampos()) {
                        $.ajax({
                            url: "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Reportes/ajax/tablaHistoricoSI.php",
                            type: "POST",
                            data: "tipo=" + $("#tipo").val() + "&si=" + $("#si").val()
                                    + "&fechaD=" + $("#fechaD").val() + "&fechaH=" + $("#fechaH").val(),
                            success: function (opciones) {
                                $("#tablaHistorico").html(opciones).show("slow");
                            }
                        });
                    }
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
                        <form name="formulario" id="formulario" action="PaginaConsultaHistorial.php" method="post" class="contact_form">
                            <li><h2>Buscar Sistema Informático</h2></li>
                            <div style="width: 600px;">
                                <table>
                                    <tr>
                                        <td>Sala:</td>
                                        <td>
                                            <?php
                                            $consultaSala = "select id_sala, nombre from sala";
                                            $query1 = $mysqli->query($consultaSala);
                                            ?>

                                            <select name="sala" id="sala" required>
                                                <option value="">Seleccione...</option>
                                                <?php while ($row = $query1->fetch_assoc()) { ?>
                                                    <option value ="<?php echo $row['id_sala'] ?>"><?php echo $row['nombre'] ?></option>
                                                    <?php
                                                }
                                                $query1->free();
                                                ?>

                                            </select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Identificaci&oacute;n:</td>
                                        <td>
                                            <select name="si" id="si" required>
                                                <option value="">Seleccione...</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Componente:</td>
                                        <td><?php $consulta = $mysqli->query("select * from tipo_componente"); ?>
                                            <select name='tipo' id="tipo" required>
                                                <option value="" >Seleccione...</option>
                                                <?php while ($row = $consulta->fetch_assoc()) { ?>
                                                    <option value ="<?php echo $row['id_tipo_componente']; ?>"><?php echo $row['descripcion'] ?> </option>
                                                    }
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>  
                                </table>
                            </div>
                            <li>
                                <button class="submit" name="volver" id="Volver">Volver</button>
                                <button class="submit" name="siguiente" id="buscar">Buscar</button>
                            </li>
                        </form>

                        <div id="tablaHistorico"></div>
                    </div>
                </div>
                <?php include_once '../foot.php'; ?>
            </div>
        </div>
    </body>
</html>
