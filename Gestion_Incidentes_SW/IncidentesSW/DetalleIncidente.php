<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
$id = filter_input(INPUT_GET, "id");
require_once '../formatoFecha.class.php';
require_once '../Conexion2.php';
$queryIncidente = "SELECT I.idIncidente, I.id_sistema_informatico AS si, I.fecha, T.nombre_turno AS turno,
    S.nombre AS sala, I.descripcion, CI.nombre AS causa_incidente, I.id_estado AS idEstado, E.nombre_estado AS estado,
    P.apellido AS apellido_reporto, P.nombre AS nombre_reporto, R.nombre as nombre_rol
    FROM incidente_software I 
    INNER JOIN persona P ON I.id_persona_reporte = P.id_persona
    INNER JOIN causa_incidente_software CI ON I.id_causa_incidente = CI.idCausa
    INNER JOIN estado E ON I.id_estado = E.id_estado
    INNER JOIN turno T ON I.id_turno = T.id_turno
    INNER JOIN sistema_informatico SI ON SI.id_sistema_informatico = I.id_sistema_informatico
    INNER JOIN sala S ON SI.id_sala = S.id_sala 
    INNER JOIN rol R on I.id_rol_persona_reporte = R.id_rol
    WHERE I.idIncidente = " . $id;
// A.nombre_actividad, A.nivel_actividad, A.responsable1, A.responsable2,    LEFT JOIN actividad A ON I.id_actividad_desarollo = A.id_actividad
//echo $queryIncidente . "</br>";
$buscarIncidentes = $mysqli->query($queryIncidente);

if (!$buscarIncidentes) {
    printf("Error en la consulta %s\n", mysql_error());
    exit();
}
$incidente = $buscarIncidentes->fetch_assoc();
$queryActividad = "SELECT TA.nombre, A.responsable1, A.responsable2, TA.nivel_actividad AS 'nivel'
                    FROM actividad A
                    INNER JOIN tipo_actividad TA ON A.tipo_nombre_actividad = TA.id_tipo_actividad
                    WHERE id_actividad =(SELECT I.id_actividad_desarollo 
                                        FROM incidente_software I
                                        LEFT JOIN actividad A ON I.id_actividad_desarollo = A.id_actividad
                                        WHERE I.idIncidente = " . $id . ");";
$buscarActividad = $mysqli->query($queryActividad);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Buscar Incidentes</title>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery.datetimepicker.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery.datepicker-es.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery.validate.js"></script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/jquery.datetimepicker.css" />
        <script>
            /*function ocultarVentana() {
             var ventana = document.getElementById('miVentana');
             ventana.style.display = 'none';
             }
             function mostrarVentana(e) {
             e.preventDefault();
             alert("entro!!");
             var ventana = document.getElementById('miVentana');
             ventana.style.marginTop = "100px";
             ventana.style.left = ((document.body.clientWidth - 350) / 2) + "px";
             ventana.style.display = 'block';
             }*/
            $(function () {
                var dialog, form,
                        //emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
                        name = $("#name");
                        //allFields = $([]).add(name);

                //tips = $(".validateTips");
                function addAccion() {
                    var nombre = name.val();
                    if (nombre !== "") {
                        $.ajax({
                            url: "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/IncidentesSW/ajax/agregarAccion.php",
                            type: "POST",
                            data: "nombre=" + nombre,
                            success: function () {
                                alert("Se grabo correctamente");
                                dialog.dialog("close");
                                return true;
                            }
                        });
                    }else{
                        alert("Ingrese una nueva acción");
                    }
                    return false;
                }

                dialog = $("#dialog-form").dialog({
                    autoOpen: false,
                    height: 400,
                    width: 350,
                    modal: true,
                    buttons: {
                        "Crear nueva accion": addAccion,
                        Cancel: function () {
                            dialog.dialog("close");
                        }
                    },
                    close: function () {
                        form[ 0 ].reset();
                        //allFields.removeClass("ui-state-error");
                    }
                });
                form = dialog.find("form").on("submit", function (event) {
                    event.preventDefault();
                    addAccion();
                });
                $("#agregarAccion").button().on("click", function (event) {
                    event.preventDefault();
                    dialog.dialog("open");
                });
            });
            //no le hace falta validacion
            /*allFields.removeClass("ui-state-error");
             var valid = true;
             valid = valid && checkLength( name, "username", 3, 16 );
             valid = valid && checkLength( email, "email", 6, 80 );
             valid = valid && checkLength( password, "password", 5, 16 );
             
             valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
             valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );
             valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
             
             if ( valid ) {
             $( "#users tbody" ).append( "<tr>" +
             "<td>" + name.val() + "</td>" +
             "<td>" + email.val() + "</td>" +
             "<td>" + password.val() + "</td>" +
             "</tr>" );
             dialog.dialog( "close" );
             }*/
            $(document).ready(function () {
                /*$("#finicio").datepicker({
                 dateFormat: 'dd/mm/yy',
                 maxDate: "+0D",
                 changeMonth: true,
                 onClose: function (selectedDate) {
                 $("#ffin").datepicker("option", "minDate", selectedDate);
                 }
                 });
                 $("#hinicio").datetimepicker({
                 lang: 'es',
                 format: 'H:i',
                 datepicker: false
                 });
                 $("#fecha").change(function (e) {
                 $("#ffin").val($("#finicio").val());
                 });*/
                $("#fecha").datepicker({
                    dateFormat: 'dd/mm/yy',
                    maxDate: "+0D",
                    changeMonth: true,
                });
                $("#hora").datetimepicker({
                    lang: 'es',
                    format: 'H:i',
                    datepicker: false
                });
                $("#volver").click(function (mievento) {
                    mievento.preventDefault();
                    //history.back();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/IncidentesSW/BuscarIncidente.php';
                });
                $("#cancelar").click(function (mievento) {
                    mievento.preventDefault();
                    //history.back();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/IncidentesSW/BuscarIncidente.php';
                });
                $("#agregarComponente").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/SistemaInformatico/ModificarComponentesSI.php?si=<?php echo $incidente['si'] ?>&idIncidente=<?php echo $id ?>';
                });
                $("#tipoSoftware").change(function (mievento) {
                    mievento.preventDefault();
                    var ts = document.getElementById("tipoSoftware");
                    $.ajax({
                        url: "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/IncidentesSW/ajax/cargarComponenteSW.php",
                        type: "POST",
                        data: "tipoSoftware=" + ts.value,
                        success: function (opciones) {
                            $("#softwareAfectado").html(opciones).show("slow");
                        }
                    });
                });
                $("#ninguno").click(function (mievento) {
                    var ninguno = document.getElementById("ninguno");
                    if (ninguno.checked) {
                        document.getElementById("accion").disabled = true;
                        document.getElementById("tipoSoftware").disabled = true;
                        document.getElementById("softwareAfectado").disabled = true;
                        document.getElementById("agregarAccion").disabled = true;
                        document.getElementById("agregarAccion").hidden = true;
                    } else {
                        document.getElementById("accion").disabled = false;
                        document.getElementById("tipoSoftware").disabled = false;
                        document.getElementById("softwareAfectado").disabled = false;
                        document.getElementById("agregarAccion").disabled = false;
                        document.getElementById("agregarAccion").hidden = false;
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
                        <form id="formulario" name="formulario" method="post" action="registrarDI.php" class="contact_form">
                            <lu><li><h2>Modificar Incidente</h2><span class="required_notification">Los campos con (*) son obligatorios</span></li></lu>
                            <h4>Datos incidentes</h4>
                            <div class="archive-separator"></div>
                            <div style="width: 300px;">
                                <table>
                                    <tr>
                                        <td>Nro:</td>
                                        <td colspan="3">
                                            <input type="text" readonly="true" value="<?php echo $id ?>" size="4"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fecha:</td>
                                        <td>
                                            <input type="text" value="<?php echo formatoFecha::convertirAFechaWeb($incidente['fecha']) ?>" readonly="true"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Turno:</td>
                                        <td colspan="3">
                                            <input type="text" value="<?php echo utf8_encode($incidente['turno']) ?>" readonly="true"/>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <h4>Sistema informatico afectado</h4>
                            <div class="archive-separator"></div>
                            <table>
                                <tr>
                                    <td>Institución:</td>
                                    <td>
                                        <input type="text" value="UTN-FRC" readonly="true"/>
                                    </td>
                                    <td>Edificio:</td>
                                    <td>
                                        <input type="text" value="Ing. Maders" readonly="true"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sala:</td>
                                    <td>
                                        <input type="text" value="<?php echo $incidente['sala'] ?>" readonly="true"/>
                                    </td>
                                    <td>Sistema Informatico:</td>
                                    <td>
                                        <input type="text" value="<?php echo $incidente['si'] ?>" readonly="true"/>
                                    </td>
                                </tr>
                            </table>

                            <h4>Detalle del incidente</h4>
                            <div class="archive-separator"></div>
                            <div style="width: 700px;">
                                <table>
                                    <tr>
                                        <td>Indicio de incidente:</td>
                                        <td colspan="3">
                                            <input type="text" value="<?php echo $incidente['causa_incidente'] ?>" readonly="true"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Reportó:</td>
                                        <td>
                                            <input type="text" value="<?php echo $incidente['apellido_reporto'] ?>, <?php echo $incidente['nombre_reporto'] ?>" 
                                                   readonly="true"/>
                                        </td>
                                        <td>Área:</td>
                                        <td>
                                            <input type="text" value="<?php echo $incidente['nombre_rol'] ?>" readonly="true"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Descripción del incidente:</td>
                                        <td colspan="3">
                                            <textarea cols="80" rows="8" readonly="true"><?php echo $incidente['descripcion'] ?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php
                            if ($buscarActividad && $buscarActividad->num_rows > 0) {
                                $actividad = $buscarActividad->fetch_assoc();
                                ?>
                                <h4>Actividad en desarrollo</h4>
                                <div class="archive-separator"></div>
                                <table>
                                    <tr>
                                        <td>Nombre:</td>
                                        <td>
                                            <input type="text" id="nombreAct" name="nombreAct" value="<?php echo $actividad['nombre'] ?>" readonly="true"/>
                                        </td>
                                        <td>Responsable 1:</td>
                                        <td>
                                            <input type="text" id="responsable1" name="responsable1" value="<?php echo $actividad['responsable1'] ?>" readonly="true"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nivel:</td>
                                        <td>
                                            <input type="text" id="fecha" name="fecha" value="<?php echo $actividad['nivel'] ?>" readonly="true"/>
                                        </td>
                                        <td>Responsable 2:</td>
                                        <td>
                                            <input type="text" id="responsable2" name="responsable2" value="<?php echo $actividad['responsable2'] ?>" readonly="true"/>
                                        </td>
                                    </tr>
                                </table>
                                <?php
                            } else {
                                echo '<h4>No hay actividad especificada</h4>';
                                echo '<div class="archive-separator"></div>';
                            }
                            ?>
                            <!-- **-->
                            <!-- **-->
                            <!-- **-->
                            <!-- **-->
                            <!-- Aqui van los detalles ya cargados del incidente-->
                            <?php
                            $idDetalle = 1;
                            $buscarDetallesIncidentes = "SELECT  DIS.fecha_inicio AS fecha, DIS.hora_inicio AS hora, P.nombre, P.apellido, 
                                ACS.nombre AS accion, concat(CS.descripcion,' ',IFNULL(CS.version,'')) as descripcionSoftware, 
                                TCS.descripcion AS tipoComponente, DIS.descripcion AS descripcionDetalle, DIS.id_detalle
                                FROM detalle_intervencion_software DIS
                                INNER JOIN incidente_software I ON DIS.id_incidente = I.idIncidente
                                INNER JOIN accion_correctiva_software ACS ON DIS.id_accion = ACS.idAccion
                                LEFT JOIN componente_software CS ON DIS.id_componente_software = CS.idComponente_Software
                                LEFT JOIN tipo_componente_software TCS ON CS.id_tipo_componente = TCS.idtipoComponente
                                INNER JOIN persona P ON DIS.id_responsable = P.id_persona
                                WHERE DIS.id_incidente = " . $id . " ORDER BY DIS.id_detalle";
                            //echo $buscarDetallesIncidentes;
                            $resultadoDetallesIncidentes = $mysqli->query($buscarDetallesIncidentes);
                            if ($resultadoDetallesIncidentes && $resultadoDetallesIncidentes->num_rows > 0 ) {
                                ?>
                                <fieldset><legend><h4>Intervenciones</h4></legend>
                                    <div class="archive-separator"></div>
                                    <?php
                                    $nroIntervencion = 0;
                                    while ($detalles = $resultadoDetallesIncidentes->fetch_assoc()) {
                                        //date_default_timezone_set('America/Argentina/Buenos_Aires');
                                        $nroIntervencion++;
                                        ?>
                                        <fieldset><legend><h5>Intervención nro. <?php echo $nroIntervencion ?> - Reportado por: <?php echo $detalles['apellido'] . ", " . $detalles['nombre'] ?></h5></legend>
                                            <div class="archive-separator"></div>
                                            <table>
                                                <tr>
                                                    <td>Fecha registro:</td>
                                                    <td>
                                                        <input type="text" value="<?php echo formatoFecha::convertirAFechaSolaWeb($detalles['fecha']) ?>" readonly/>
                                                    </td>
                                                    <td>Hora registro:</td>
                                                    <td>
                                                        <input type="text" value="<?php echo substr($detalles['hora'], 0, 5) ?>" readonly="true"/>
                                                    </td>
                                                </tr>
                                                <?php
                                                if ($detalles['descripcionSoftware'] != null) {
                                                    ?>
                                                    <tr>
                                                        <!--<td>*Software tratado:</td>-->

                                                        <td>
                                                            Tipo Componente: 
                                                        </td>
                                                        <td>
                                                            <input type="text" value="<?php echo $detalles['tipoComponente'] ?>" readonly="true"/>
                                                        </td>
                                                        <td>
                                                            Nombre Componente: 
                                                        </td>
                                                        <td>
                                                            <input type="text" value="<?php echo $detalles['descripcionSoftware'] ?>" readonly="true"/>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td>*Accion correctiva<br/>realizada:</td>
                                                    <td colspan="2">
                                                        <input type="text" value="<?php echo $detalles['accion'] ?>" readonly="true"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>*Descripci&oacute;n:</td>
                                                    <td colspan="3">
                                                        <textarea cols="100" rows="8"><?php echo $detalles['descripcionDetalle'] ?></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                        </fieldset>
                                        <?php
                                    }
                                    $idDetalle = $detalles['id_detalle'] + 1;
                                }
                                ?>
                            </fieldset>    

                            <!-----------------------------------------------------------------------------------------------------------------!>
                            
                            <?php if ($incidente['idEstado'] == 1) { ?>
                                <!-- Aqui se coloca el nuevo detalle de incidente ------------------------------------------------------>
                                <fieldset><legend><h4>Nueva intervención</h4></legend>
                                    <fieldset><legend>Detalle de intervención</legend>
                                        <div style="width: 800px;">
                                            <table>
                                                <tr>
                                                    <td>Nro:</td>
                                                    <td colspan="3">
                                                        <input type="text" id="nroInterv" name="nroInterv" value="<?php echo $idDetalle ?>" required/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>*Fecha registro:</td>
                                                    <td>
                                                        <input type="text" id="fecha" name="fecha" value="<?php echo date('d/m/Y') ?>" placeholder="__/__/__"  required/>
                                                    </td>
                                                    <td>*Hora registro:</td>
                                                    <td>
                                                        <input type="text" id="hora" name="hora" value="<?php echo substr(date('d/m/y H:i'), 9, 13) ?>" placeholder="__:__" class="time" required/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </fieldset>
                                    <fieldset><legend>Componente</legend>
                                        <div style="width: 800px;">
                                            <table id="componentesTratados">
                                                <tr>
                                                    <td>*Tipo de software:</td>
                                                    <td colspan="2">
                                                        <select id="tipoSoftware" name="tipoSoftware">
                                                            <option value="">Seleccione...</option>
                                                            <?php
                                                            $consultaTS = "SELECT tipo_componente_software.idtipoComponente, 
                                                                tipo_componente_software.descripcion 
                                                                FROM tipo_componente_software";
                                                            $resultadoTS = $mysqli->query($consultaTS);
                                                            if (mysql_errno() == 0) {
                                                                while ($row = $resultadoTS->fetch_assoc()) {
                                                                    ?>
                                                                    <option value ="<?php echo $row['idtipoComponente'] ?>"><?php echo $row['descripcion'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>*Software tratado:</td>
                                                    <td>
                                                        <select id="softwareAfectado" name="softwareAfectado">
                                                            <option value="">Seleccione...</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <input type="checkbox" name="ninguno" id="ninguno" value="0" 
                                                                   class="componentes" style="height: 30px"/>
                                                            <label for="ninguno">Ninguno</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>*Accion correctiva<br/>realizada:</td>
                                                    <td colspan="2">
                                                        <select name="accion" id="accion" required>
                                                            <option value="">Seleccione...</option>
                                                            <?php
                                                            echo $incidente['causa_incidente'];
                                                            $consultaAccionesCorrectivas = "SELECT acs.idAccion as id, acs.nombre 
                                                                FROM accion_softwarexcausa_software ascs 
                                                                INNER JOIN accion_correctiva_software acs  on ascs.id_accion=acs.idAccion 
                                                                inner join causa_incidente_software cs on ascs.id_causa=cs.idCausa 
                                                                where cs.nombre='" . $incidente['causa_incidente'] . "'";
                                                            $resultadoAcccionesCorrectivas = $mysqli->query($consultaAccionesCorrectivas);
                                                            if ($resultadoAcccionesCorrectivas) {
                                                                while ($row = $resultadoAcccionesCorrectivas->fetch_assoc()) {
                                                                    ?>
                                                                    <option value="<?php echo $row['id'] ?>">
                                                                        <?php echo $row['nombre'] ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <!--<button class="submit" name="agregarAccion" id="agregarAccion" onclick="javascript:mostrarVentana();">+</button>-->
                                                        <button class="submit" name="agregarAccion" id="agregarAccion">+</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>*Descripci&oacute;n:</td>
                                                    <td colspan="2">
                                                        <textarea name="descripcion" cols="100" rows="8"></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </fieldset>
                                    <!----------------------------------------------------------------------------------------------------------------------------->
                                    <!----------------------------------------------------------------------------------------------------------------------------->
                                    <!----------------------------------------------------------------------------------------------------------------------------->
                                    <fieldset><legend>Actualización estado Incidente</legend>
                                        <div style="width: 250px;">
                                            <table>
                                                <tr>
                                                    <td>*Estado:</td>
                                                    <td>
                                                        <select id="estado" name="estado" required>
                                                            <option value="">Seleccione...</option>
                                                            <?php
                                                            $qConsultaEstado = "SELECT E.nombre_estado AS nombre, E.id_estado AS id 
                                                                FROM estado E";
                                                            $buscarEstado = $mysqli->query($qConsultaEstado);
                                                            if ($buscarEstado) {
                                                                while ($row = $buscarEstado->fetch_assoc()) {
                                                                    ?>
                                                                    <option value ="<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </fieldset>
                                    <input type="hidden" value="<?php echo $id ?>" name="idIncidente"/>
                                    <input type="hidden" value="<?php echo $incidente['si'] ?>" name="idSI"/>
                                    <!-- Por ultimo los botones-->
                                    <button class="submit" name="cancelar" id="cancelar">Cancelar</button>
                                    <button class="submit" name="registrar" type="submit" id="modificar">Registrar</button>
                                <?php } else { ?>
                                    <h4>Estado del Incidente: <?php echo $incidente['estado'] ?></h4>
                                    <button class="submit" name="volver" id="volver">Volver</button>
                                <?php } ?>
                            </fieldset>

                            <!---------------------------------------------------->
                            <div id="dialog-form" title="Agregar nueva accion">
                                <p class="validateTips">Todas los campos son requeridos.</p>

                                <form>
                                    <fieldset>
                                        <label for="name">Nombre Accion</label>
                                        <input type="text" name="name" id="name" value="" class="text ui-widget-content ui-corner-all">

                                        <!-- Allow form submission with keyboard without duplicating the dialog button -->
                                        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                    </fieldset>
                                </form>
                            </div>
                            <!---------------------------------------------------->
                        </form>
                        <?php include_once './agregarAccionXIndicio.php'; ?>
                    </div>
                </div>
                <?php include_once './../foot.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php
$mysqli->close();
