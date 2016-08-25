<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
$id = filter_input(INPUT_GET, "id");
require_once '../formatoFecha.class.php';
//require_once '../Conexion.php';
require_once '../Conexion2.php';
$queryIncidente = "SELECT I.idIncidente, I.id_sistema_informatico AS si, I.fecha, T.nombre_turno AS turno,
                    S.nombre AS sala, I.descripcion, CI.nombre AS causa_incidente, I.id_estado AS idEstado, E.nombre_estado AS estado,
                    A.nombre_actividad, A.nivel_actividad, A.responsable1, A.responsable2, P.apellido AS apellido_reporto,
                    P.nombre AS nombre_reporto, R.nombre as nombre_rol
                    FROM incidente_software I 
                    INNER JOIN persona P ON I.id_persona_reporte = P.id_persona
                    INNER JOIN causa_incidente_software CI ON I.id_causa_incidente = CI.idCausa
                    INNER JOIN estado E ON I.id_estado = E.id_estado
                    LEFT JOIN actividad A ON I.id_actividad_desarollo = A.id_actividad
                    INNER JOIN turno T ON I.id_turno = T.id_turno
                    INNER JOIN sistema_informatico SI ON SI.id_sistema_informatico = I.id_sistema_informatico
                    INNER JOIN sala S ON SI.id_sala = S.id_sala INNER JOIN rol R on P.id_rol = R.id_rol
                    WHERE I.idIncidente = " . $id;

//echo $queryIncidente . "</br>";
$buscarIncidentes = $mysqli->query($queryIncidente);
if (!$buscarIncidentes) {
    printf("Error en la consulta %s\n", mysql_error());
    exit();
}
//$query1 = mysql_query($buscarIncidente);
//if (mysql_errno() || mysql_affected_rows() <= 0) {
//    printf("Error en la consulta %s\n", mysql_error());
//    exit();
//}

$incidente = $buscarIncidentes->fetch_assoc();
//$incidente = mysql_fetch_array($query1);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Buscar Incidentes</title>
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery.datetimepicker.js"></script>
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery.datepicker-es.js"></script>
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery.validate.js"></script>
        <link rel="stylesheet" type="text/css" href="/IncidentesSoftware/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="/IncidentesSoftware/css/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="/IncidentesSoftware/css/jquery.datetimepicker.css" />
        <script>
            $(document).ready(function () {
                $("#finicio").datepicker({
                    dateFormat: 'dd/mm/yy',
                    maxDate: "+0D",
                    changeMonth: true,
                    onClose: function (selectedDate) {
                        $("#ffin").datepicker("option", "minDate", selectedDate);
                    }
                });
                $("#ffin").datepicker({
                    dateFormat: 'dd/mm/yy',
                    maxDate: "+0D",
                    changeMonth: true,
                    onClose: function (selectedDate) {
                        $("#finicio").datepicker("option", "maxDate", selectedDate);
                    }
                });
                $("#finicio").change(function (e) {
                    $("#ffin").val($("#finicio").val());
                });
                $("#hinicio").datetimepicker({
                    lang: 'es',
                    format: 'H:i',
                    datepicker: false
                });
                $("#hfin").datetimepicker({
                    lang: 'es',
                    format: 'H:i',
                    datepicker: false
                });
                $("#volver").click(function (mievento) {
                    mievento.preventDefault();
                    //history.back();
                    window.location = '/IncidentesSoftware/Incidentes/BuscarIncidente.php';
                });
                $("#cancelar").click(function (mievento) {
                    mievento.preventDefault();
                    //history.back();
                    window.location = '/IncidentesSoftware/Incidentes/BuscarIncidente.php';
                });
                $("#agregarComponente").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/IncidentesSoftware/SistemaInformatico/ModificarComponentesSI.php?si=<?php echo $incidente['si'] ?>&idIncidente=<?php echo $id ?>';
                });
                $("#formulario").validate({
                    submitHandler: function (form) {
                        //if ($("#estado").val() !== "Seleccione...") {
                        if (verificarComponentes()) {
                            if (verificarAcciones()) {
                                if (verificarFechas()) {
                                    //alert("submit");
                                    $(form).submit();
                                } else {
                                    alert("Fecha y hora de incio es mayor que fecha y hora de fin");
                                }
                            } else {
                                alert("Seleccione al menos una accion");
                            }
                        } else {
                            alert("Seleccione al menos un componente");
                        }
                        /*} else {
                         alert("Seleccione un estado");
                         }*/
                    }
                });
                function verificarComponentes() {
                    var ban = false;
                    var componentes = document.getElementsByClassName("componentes");
                    for (var i = 0; i < componentes.length; i++) {
                        if (componentes[i].checked) {
                            ban = true;
                            break;
                        }
                    }
                    return ban;
                }
                ;
                function verificarAcciones() {
                    var ban = false;
                    var acciones = document.getElementsByClassName("acciones");
                    for (var i = 0; i < acciones.length; i++) {
                        if (acciones[i].checked) {
                            ban = true;
                            break;
                        }
                    }
                    return ban;
                }
                ;
                function verificarFechas() {
                    var hinicio = $("#hinicio").val() + "";
                    var hfin = $("#hfin").val() + "";
                    if ($("#finicio").val() === $("#ffin").val()) {
                        if (hinicio >= hfin) {
                            //alert("mal");
                            return false;
                        }
                    }
                    //alert("bien");
                    return true;
                }
                
                $("#tipoComponente[]").change(function (mievento) {
                    mievento.preventDefault();
                    alert("aidsfhsd");
                    var ultimo = document.getElementById("tipoDocumento").lastElementChild;
                    $.ajax({
                        url: "/IncidentesSoftware/Incidentes/cargarAccionCorrectiva.php",
                        type: "POST",
                        data: "tipoComponente=" + ultimo.value,
                        success: function (opciones) {
                            $("#accion").html(opciones).show("slow");
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
                        <form id="formulario" name="formulario" method="post" action="registrarDI.php" class="contact_form">
                            <lu><li><h2>Modificar Incidente</h2><span class="required_notification">Los campos con (*) son obligatorios</span></li></lu>
                            <h4>Datos incidentes</h4>
                            <div class="archive-separator"></div>
                            <div style="width: 300px;">
                                <table>
                                    <tr>
                                        <td>Nro:</td>
                                        <td colspan="3">
                                            <input type="text" id="nro" name="nro" readonly="true" value="<?php echo $id ?>" size="4"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Fecha:</td>
                                        <td>
                                            <input type="text" id="fecha" name="fecha" value="<?php echo formatoFecha::convertirAFechaWeb($incidente['fecha']) ?>" readonly="true"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Turno:</td>
                                        <td colspan="3">
                                            <input type="text" id="turno" name="turno" value="<?php echo $incidente['turno'] ?>" readonly="true"/>
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
                                        <input type="text" id="institucion" name="institucion" value="UTN-FRC" readonly="true"/>
                                    </td>
                                    <td>Edificio:</td>
                                    <td>
                                        <input type="text" id="edificio" name="edificio" value="Ing. Maders" readonly="true"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sala:</td>
                                    <td>
                                        <input type="text" id="sala" name="sala" value="<?php echo $incidente['sala'] ?>" readonly="true"/>
                                    </td>
                                    <td>Sistema Informatico:</td>
                                    <td>
                                        <input type="text" id="si" name="si" value="<?php echo $incidente['si'] ?>" readonly="true"/>
                                    </td>
                                </tr>
                            </table>

                            <h4>Detalle del incidente</h4>
                            <div class="archive-separator"></div>
                            <div style="width: 700px;">
                                <table>
                                  <!-- <tr>
                                        <td>Software afectado:</td> 
                                       <!-- <td colspan="3">
                                            <input type="text" id="componenteAfectado" 
                                                   name="componenteAfectado" value="<?php echo $incidente['id_tipo_componente_afectado'] ?>" 
                                                   readonly="true"/>
                                        </td>-->
<!--                                        
                                 <td colspan="3">
                                    <select id="softwareAfectado" name="softwareAfectado">
                                        /* //<?php 
//                                            $consultaSoftwareAfectado = "SELECT  sx.id_componente_software as id, concat(cs.descripcion, ' ',IFNULL(cs.version,'')) as descripcionSoftware
//                                                                         FROM gestion_incidentes.salaxcomponente_software sx inner join componente_software cs on sx.id_componente_software=cs.idComponente_software inner join sala s on SX.id_sala = S.id_sala 
//                                                                         inner join Sistema_informatico SI on SI.id_sala=S.id_sala 
//                                                                         where SI.id_sistema_informatico= " . $incidente['si'];
//                                            $resultadoSoftwareAfectado =  $mysqli->query($consultaSoftwareAfectado);
//                                            if(mysql_errno() == 0){
//                                            while ($row = $resultadoSoftwareAfectado->fetch_assoc()) { ?>
                                            <option value ="//<?php echo $row['id'] ?>"><?php echo $row['descripcionSoftware'] ?></option>
                                            // } <?php
                                      //  } ?>
                                    </select>
                                </td>
                                <td>-->
                                    
                                </td>
                              </tr> -->
                                    <tr>
                                        <td>Indicio de incidente:</td>
                                        <td colspan="3">
                                            <input type="text" id="causa" name="causa" 
                                                   value="<?php echo $incidente['causa_incidente'] ?>" 
                                                   readonly="true" disable="true"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Reportó:</td>
                                        <td>
                                            <input type="text" id="reporto" name="reporto" 
                                                   value="<?php echo $incidente['apellido_reporto'] ?>, <?php echo $incidente['nombre_reporto'] ?>" 
                                                   readonly="true" disabled="true"/>
                                        </td>
                                        <td>Área:</td>
                                        <td>
                                            <input type="text" id="area" name="area" value="<?php echo $incidente['nombre_rol'] ?>" readonly="true" disabled="true"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Descripción del incidente:</td>
                                        <td colspan="3">
                                            <textarea id="descripcion" name="descripcion" cols="40" rows="4" readonly="true"><?php echo $incidente['descripcion'] ?></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php
                            if ($incidente['nombre_actividad'] != NULL) {
                                ?>
                                <h4>Actividad en desarrollo</h4>
                                <div class="archive-separator"></div>
                                <table>
                                    <tr>
                                        <td>Nombre:</td>
                                        <td>
                                            <input type="text" id="nombreAct" name="nombreAct" value="<?php echo $incidente['nombre_actividad'] ?>" readonly="true"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nivel:</td>
                                        <td>
                                            <input type="text" id="fecha" name="fecha" value="<?php echo $incidente['nivel_actividad'] ?>" readonly="true"/>
                                        </td>
                                        <td>Responsable 1:</td>
                                        <td>
                                            <input type="text" id="responsable1" name="responsable1" value="<?php echo $incidente['responsable1'] ?>" readonly="true"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Responsable 2:</td>
                                        <td>
                                            <input type="text" id="responsable2" name="responsable2" value="<?php echo $incidente['responsable2'] ?>" readonly="true"/>
                                        </td>
                                    </tr>
                                </table>
                                <!-- Aqui van los detalles ya cargados del incidente-->
                                <?php
                            } else {
                                ?>
                                <h4>No hay actividad especificada</h4>
                                <div class="archive-separator"></div>
                                <?php
                            }
                            /*$queryDetalles = "SELECT DI.id_detalle_intervencion AS id, DI.descripcion, DI.fecha_inicio, DI.hora_inicio, DI.fecha_fin, DI.hora_fin, 
                        DI.motivo_no_finalizacion AS motivo, P.nombre, P.apellido
                        FROM detalle_intervencion DI 
                        INNER JOIN persona P ON P.id_persona = DI.id_persona_detalle_intervencion
                        WHERE DI.id_incidente = " . $id;*/
                            $queryDetalles="SELECT DI.id_detalle AS id, DI.descripcion, DI.fecha_inicio, DI.hora_inicio, DI.fecha_fin, DI.hora_fin, P.nombre, P.apellido 
                                FROM detalle_intervencion_software DI INNER JOIN persona P ON P.id_persona = DI.id_responsable 
                                WHERE DI.id_incidente = " . $id;
                               $idDetalle = 0;

                            $buscarDetalles = $mysqli->query($queryDetalles);
                            if ($buscarDetalles && $mysqli->affected_rows > 0) {

//                            $result = mysql_query($queryDetalles);
//                            if (mysql_errno() == 0 && mysql_affected_rows() > 0) {
                                ?>
                                <fieldset><legend><h4>Intervenciones</h4></legend>
                                    <div class="archive-separator"></div>
                                    <?php
                                    while ($detalles = $buscarDetalles->fetch_assoc()) {
//                                    while ($detalles = mysql_fetch_array($result)) {
                                        $idDetalle = $idDetalle + 1;
                                        ?>
                                            <?php
                                            date_default_timezone_set('America/Argentina/Buenos_Aires');
                                            ?>
                                        <fieldset><legend><h5>Intervención nro. <?php echo $idDetalle ?> - Reportado por: <?php echo $detalles['apellido'] . ", " . $detalles['nombre'] ?></h5></legend>
                                            <div class="archive-separator"></div>
                                            <table>
                                                <!--<tr>
                                                    <td>Fecha inicio:</td>
                                                    <td>
                                                        <input type="text" id="finicioInterv<?php echo $idDetalle ?>" value="<?php echo formatoFecha::convertirAFechaSolaWeb($detalles['fecha_inicio']) ?>" readonly/>
                                                    </td>
                                                    <td>Hora inicio:</td>
                                                    <td>
                                                        <input type="text" id="hinicioInterv<?php echo $idDetalle ?>" value="<?php echo substr($detalles['hora_inicio'], 0, 5) ?>" readonly/>
                                                    </td>
                                                </tr> -->
                                                <tr>
                                                    <td>Fecha fin:</td>
                                                    <td>
                                                        <input type="text" id="ffinInterv<?php echo $idDetalle ?>" value="<?php  echo date('d/m/y') /*echo formatoFecha::convertirAFechaSolaWeb($detalles['fecha_fin'])*/ ?>" readonly/>
                                                    </td>
                                                    <td>Hora fin:</td>
                                                    <td>
                                                        <input type="text" id="hfinInterv<?php echo $idDetalle ?>" value="<?php echo substr($detalles['hora_fin'], 0, 5) ?>" readonly="true"/>
                                                    </td>
                                                </tr>
                                                <!-- aqui debe ir la consulta de los componentes-->
                                                <?php
                                                $queryComponentes = "SELECT TC.*
                                                                     FROM detalle_intervencion DI
                                    INNER JOIN componentexdetalle_intervencion CXDI ON DI.id_detalle_intervencion = CXDI.id_detalle_intervencion 
                                    AND DI.id_incidente = CXDI.id_incidente
                                    INNER JOIN componente C ON C.id_componente = CXDI.id_componente
                                    INNER JOIN tipo_componente TC ON C.id_tipo_componente = TC.id_tipo_componente
                                    WHERE DI.id_detalle_intervencion = " . $detalles['id'] .
                                                        " AND DI.id_incidente = " . $id;

                                                $buscarComponentes = $mysqli->query($queryComponentes);
                                                if ($buscarComponentes && $mysqli->affected_rows > 0) {

//                                                $resultComponentes = mysql_query($queryComponentes);
//                                                if (mysql_errno() == 0 && mysql_affected_rows() > 0) {
                                                    ?>
                                                    <tr>
                                                        <td>Componente afectado:</td>
                                                        <td colspan="3">
                                                            <?php
                                                            while ($componentes = $buscarComponentes->fetch_assoc()) {
//                                                            while ($componentes = mysql_fetch_array($resultComponentes)) {
                                                                ?>
                                                                <input type="text" readonly="true"
                                                                       id="<?php echo $componentes['descripcion'] ?>_det<?php echo $detalles['id'] ?>" 
                                                                       value="<?php echo $componentes['descripcion'] ?>"/><br/>
                                                                       <?php
                                                                   }
                                                                   ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>

                                                <tr>
                                                    <td>Descripción:</td>
                                                    <td colspan="3">
                                                        <textarea id="descripcion" name="descripcionInterv" id="descripcionInterv" cols="100" rows="4" readonly><?php echo $detalles['descripcion'] ?></textarea>
                                                    </td>
                                                </tr>
                                                <!-- aqui debe ir la consulta de las acciones-->
                                                <?php
                                                $queryAcciones = "SELECT AC.nombre AS descripcion
                                FROM detalle_intervencion DI 
                                INNER JOIN accion_correctivaxdetalle_intervencion ACXDI ON DI.id_detalle_intervencion = ACXDI.id_detalle_intervencion
                                AND DI.id_incidente = ACXDI.id_incidente
                                INNER JOIN accion_correctiva AC ON AC.id_accion = ACXDI.id_accion
                                WHERE DI.id_detalle_intervencion = " . $detalles['id'] .
                                                        " AND DI.id_incidente = " . $id;
                                               

                                                $buscarAcciones = $mysqli->query($queryAcciones);
                                                if ($buscarAcciones && $mysqli->affected_rows > 0) {

//                                                $resultAcciones = mysql_query($queryAcciones);
//                                                if (mysql_errno() == 0 && mysql_affected_rows() > 0) {
                                                    ?>
                                                    <tr>
                                                        <td>Acciones correctivas:</td>
                                                        <td colspan="3">
                                                            <?php
                                                            while ($acciones = $buscarAcciones->fetch_assoc()) {
//                                                            while ($acciones = mysql_fetch_array($resultAcciones)) {
                                                                ?>
                                                                <input type="text" readonly="true"
                                                                       id="<?php echo $acciones['descripcion'] ?>_det<?php echo $acciones['id'] ?>" 
                                                                       value="<?php echo $acciones['descripcion'] ?>" size="40"/><br/>
                                                                       <?php
                                                                   }
                                                                   ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                        </fieldset>
                                        <?php
                                    }
                                }
                                ?>
                            </fieldset>    
                            <?php if ($incidente['idEstado'] == 1) { ?>


                                <!-- Aqui se coloca el nuevo detalle de incidente ------------------------------------------------------>
                                <fieldset><legend><h4>Nueva intervención</h4></legend>
                                    <fieldset><legend>Detalle de intervención</legend>
                                        <div style="width: 800px;">
                                            <table>
                                                <tr>
                                                    <td>Nro:</td>
                                                    <td colspan="3">
                                                        <input type="text" id="nroInterv" name="nroInterv" value="<?php echo $idDetalle = $idDetalle + 1; ?>" required/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                  <!--  <td>*Fecha inicio:</td>
                                                    <td>
                                                        <input type="text" id="finicio" name="finicio" value="" placeholder="__/__/__" required/>
                                                    </td>
                                                    <td>*Hora inicio:</td>
                                                    <td>
                                                        <input type="text" id="hinicio" name="hinicio" value="" placeholder="__:__" class="time" required/>
                                                    </td>-->
                                                </tr>
                                                <tr>
                                                    <td>*Fecha fin:</td>
                                                    <td>
                                                        <input type="text" id="ffin" name="ffin" value="<?php echo date('d/m/y') ?>" placeholder="__/__/__"  required/>
                                                    </td>
                                                    <td>*Hora fin:</td>
                                                    <td>
                                                        <input type="text" id="hfin" name="hfin" value="<?php substr(date('d/m/y g:i'), 9, 13) ?>" placeholder="__:__" class="time" required/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </fieldset>
                                    <fieldset><legend>Componente</legend>
                                        <div style="width: 800px;">
                                            <table id="componentesTratados">
                                                <tr>
                                                        <td>*Software tratado:</td>
                                                        <td>

                                                            <!-- $qComponentesSI =  "SELECT TC.id_tipo_componente AS id, TC.descripcion AS nombre 
                                                      FROM sistema_informatico SI 
                                                      INNER JOIN componente C ON C.id_sistema_informatico = SI.id_sistema_informatico
                                                      INNER JOIN tipo_componente TC ON C.id_tipo_componente = TC.id_tipo_componente
                                                      WHERE SI.id_sistema_informatico = " . $incidente['si'];-->
                                                            <select id="softwareAfectado" name="softwareAfectado">
                                                                <?php
                                                                $consultaSoftwareAfectado = "SELECT  sx.id_componente_software as id, concat(cs.descripcion, 
                                                                    ' ',IFNULL(cs.version,'')) as descripcionSoftware 
                                                                    FROM gestion_incidentes.salaxcomponente_software sx inner join componente_software cs 
                                                                    on sx.id_componente_software=cs.idComponente_software 
                                                                    inner join sala s on sx.id_sala = s.id_sala 
                                                                    inner join sistema_informatico SI on SI.id_sala=s.id_sala 
                                                                    where SI.id_sistema_informatico= " . $incidente['si'];
                                                                $resultadoSoftwareAfectado = $mysqli->query($consultaSoftwareAfectado);
                                                                if (mysql_errno() == 0) {
                                                                    while ($row = $resultadoSoftwareAfectado->fetch_assoc()) {
                                                                        ?>
                                                                        <option value ="<?php echo $row['id'] ?>"><?php echo $row['descripcionSoftware'] ?></option>
                                                                    <?php }
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div><input type="checkbox" name="componente0" id="comp0" value="0" class="componentes" style="height: 30px"/><label for="comp0">Ninguno</label></div>
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
                                                                                                where cs.nombre='". $incidente['causa_incidente'] ."'";
                                                                //$query3 = mysql_query($consultaInstitucion);
                                                                $resultadoAcccionesCorrectivas = $mysqli->query($consultaAccionesCorrectivas);
                                                                if ($resultadoAcccionesCorrectivas ) {
                                                                    //while ($row = mysql_fetch_array($query3)) {
                                                                    while ($row = $resultadoAcccionesCorrectivas->fetch_assoc()) {
                                                                        ?>
                                                                        <option value="<?php echo $row['id'] ?>" selected="true"><?php echo $row['nombre'] ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </fieldset>
                                    <!----------------------------------------------------------------------------------------------------------------------------->
                                    <?php /*
                                    <fieldset><legend>Componente</legend>
                                        <div style="float: left; width: 750px">
                                            <?php
                                            $qTipoComponente = "SELECT TC.id_tipo_componente AS id, TC.descripcion AS nombre FROM tipo_componente TC";
                                            $buscarTC = $mysqli->query($qTipoComponente);
                                            if ($buscarTC) {

//                                            $query1 = mysql_query($consulta);
//                                            if (mysql_errno() == 0) {
                                                $qComponentesSI = "SELECT TC.id_tipo_componente AS id, TC.descripcion AS nombre 
                                                FROM sistema_informatico SI 
                                                INNER JOIN componente C ON C.id_sistema_informatico = SI.id_sistema_informatico
                                                INNER JOIN tipo_componente TC ON C.id_tipo_componente = TC.id_tipo_componente
                                                WHERE SI.id_sistema_informatico = " . $incidente['si'];
                                                //echo $componentesSI."</br>";

                                                $buscarComponenteSI = $mysqli->query($qComponentesSI);
                                                while ($rowSI = $buscarComponenteSI->fetch_assoc()) {
                                                    $compSI[] = $rowSI['nombre'];
                                                }

//                                                $query2 = mysql_query($componentesSI);
//                                                while ($rowSI = mysql_fetch_assoc($query2)) {
//                                                    $compSI[] = $rowSI['nombre'];
//                                                }
                                                //echo print_r($compSI)."</br>";

                                                while ($row = $buscarTC->fetch_assoc()) {


//                                                while ($row = mysql_fetch_array($query1)) {
                                                    //echo print_r($row['nombre'])."</br>";
                                                    if (!empty($compSI) && in_array($row['nombre'], $compSI)) {
                                                        ?>
                                                        <div style="float: left; height: 30px"><input type="checkbox" name="componente[<?php echo $row['id'] ?>]" id="componente[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>" class="componentes"/>
                                                            <label for="componente[<?php echo $row['id'] ?>]"><?php echo $row['nombre'] ?></label><br/></div>
                                                    <?php } else { ?>
                                                        <div style="float: left; height: 30px"><input type="checkbox" name="componente[<?php echo $row['id'] ?>]" id="componente[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>" disabled="true"/><label for="componente[<?php echo $row['id'] ?>]" style="color: red;"><?php echo $row['nombre'] ?></label><br/></div>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            <div><input type="checkbox" name="componente0" id="comp0" value="0" class="componentes" style="height: 30px"/><label for="comp0">Ninguno</label></div>
                                        </div>
                                        <div><button class="submitComponente" align="left" type="button" name="agregarComponente" id="agregarComponente">Cargar Componente</button></div>
                                        <div style="clear: both;"><p style="color: red; font-size: 13px">(**) Los componentes en ROJO no se encuentran cargados en el sistema</p></div>
                                    </fieldset>


                                    <fieldset><legend>Descripción</legend>
                                        <textarea id="descripcion" name="descripcionInterv" id="descripcionInterv" value="" cols="80" rows="4" required></textarea>
                                    </fieldset>

                                    <fieldset><legend>Acción correctiva</legend>
                                        <div style="width: 750px;">
                                            <?php
                                            $qConsultaAccion = "SELECT AC.id_accion AS id, AC.nombre FROM accion_correctiva AC";
                                            $buscarAcciones = $mysqli->query($qComponentesSI);
                                            if ($buscarAcciones) {
                                                while ($row = $buscarAcciones->fetch_assoc()) {

//                                            $query1 = mysql_query($consulta);
//                                            if (mysql_errno() == 0) {
//                                                while ($row = mysql_fetch_array($query1)) {
                                                    ?>
                                                    <div style="float: left; height: 50px;"><input type="checkbox" name="accion<?php echo $row['id'] ?>" id="accion<?php echo $row['id'] ?>" value="<?php echo $row['id'] ?>" class="acciones"/><label for="accion<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></label><br/></div>

                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </fieldset>
                                    */ ?>
                                    <!----------------------------------------------------------------------------------------------------------------------------->
                                    <!----------------------------------------------------------------------------------------------------------------------------->
                                    <!--<div><button  type="button" name="agregarComponente" id="agregarComponente">Agregar</button></div>-->
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

//                                                            $query1 = mysql_query($consultaEstado);
//                                                            if (mysql_errno() == 0) {
//                                                                while ($row = mysql_fetch_array($query1)) {
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
                                    <button class="submit" name="registrar" type="submit" id="modificar">Registrar</button>
                                    <button class="submit" name="cancelar" id="cancelar">Cancelar</button>
                                <?php } else { ?>
                                    <h4>Estado del Incidente: <?php echo $incidente['estado'] ?></h4>
                                    <button class="submit" name="volver" id="volver">Volver</button>
                                <?php } ?></fieldset>
                        </form>
                    </div>
                </div>
                <?php include_once './../foot.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php
$mysqli->close();
