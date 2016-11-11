<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
$id = filter_input(INPUT_GET, "id");
require_once '../formatoFecha.class.php';
require_once '../Conexion2.php';
$queryIncidente = "SELECT I.id_incidente, I.id_sistema_informatico_afectado AS si, I.fecha, T.nombre_turno AS turno,
                    S.nombre AS sala, I.descripcion, CI.nombre AS causa_incidente, I.id_estado AS idEstado, E.nombre_estado AS estado,
                    TA.nombre AS 'nombre_actividad', TA.nivel_actividad, A.responsable1, A.responsable2, P.apellido AS apellido_reporto,
                    P.nombre AS nombre_reporto, R.nombre AS rol_reporto, TC.descripcion AS 'tipo_componente' 
                    FROM incidente I 
                    INNER JOIN persona P ON I.id_persona_reporto = P.id_persona
                    INNER JOIN causa_incidente CI ON I.id_causa_incidente = CI.id_tipo_incidente
                    INNER JOIN rol R ON I.id_rol_persona_reporto = R.id_rol
                    INNER JOIN estado E ON I.id_estado = E.id_estado
                    LEFT JOIN actividad A ON I.id_actividad_en_desarrollo = A.id_actividad
                    LEFT JOIN tipo_actividad TA ON A.tipo_nombre_actividad = TA.id_tipo_actividad 
                    INNER JOIN turno T ON I.id_turno = T.id_turno
                    INNER JOIN sala S ON I.id_sala = S.id_sala
                    INNER JOIN tipo_componente TC ON TC.id_tipo_componente = I.id_tipo_componente_afectado
                    WHERE I.id_incidente = " . $id;
//echo $queryIncidente . "</br>";
$buscarIncidentes = $mysqli->query($queryIncidente);
if (!$buscarIncidentes) {
    printf("Error en la consulta %s\n", mysql_error());
    exit();
}
$incidente = $buscarIncidentes->fetch_assoc();
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
        <script type="text/javascript">
            function quitarComponente(index) {
                $.ajax({
                    url: "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/IncidentesHW/ajax/tablaComponentesAfectados.php",
                    type: "POST",
                    data: "quitar=" + index,
                    success: function (opciones) {
                        $("#tablaCA").html(opciones).show("slow");
                    }
                });
            }
            function verificarFechas() {
                var hinicio = $("#hinicio").val() + "";
                var hfin = $("#hfin").val() + "";
                if ($("#finicio").val() === $("#ffin").val()) {
                    if (hinicio >= hfin) {
                        return false;
                    }
                }
                return true;
            }
//            function verificarComponentes() {
//                var ban = false;
//                var componentes = document.getElementsByClassName("componentes");
//                for (var i = 0; i < componentes.length; i++) {
//                    if (componentes[i].checked) {
//                        ban = true;
//                        break;
//                    }
//                }
//                return ban;
//            }
            $(document).ready(function () {
                $("#tipoComponente").change(function (mievento) {
                    if ($("#tipoComponente").val() != "") {
                        var selectedTC = tipoComponente.options[tipoComponente.selectedIndex].text;
                        $.ajax({
                            url: "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/IncidentesHW/ajax/cargarAccionCorrectiva.php",
                            type: "POST",
                            data: "tipoComponente=" + selectedTC,
                            success: function (opciones) {
                                $("#accion").html(opciones).show("slow");
                            }
                        });
                    } else {
                        $("#accion").html('<option value="">Seleccione...</option>');
                    }
                });

                $("#btnAgregar").click(function (mievento) {
                    mievento.preventDefault();
                    var tipoComponente = document.getElementById("tipoComponente");
                    var selectedTC = tipoComponente.options[tipoComponente.selectedIndex].text;
                    var accion = document.getElementById("accion");
                    var selectedA = accion.options[accion.selectedIndex].text;
                    $.ajax({
                        url: "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/IncidentesHW/ajax/tablaComponentesAfectados.php",
                        type: "POST",
                        data: "idComponente=" + $("#tipoComponente").val() +
                                "&idAccion=" + $("#accion").val() +
                                "&combo=" + selectedTC +
                                "&accion=" + selectedA,
                        success: function (opciones) {
                            $("#tablaCA").html(opciones).show("slow");
                        }
                    });
                });
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
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/IncidentesHW/BuscarIncidente.php';
                });
                $("#cancelar").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '/<?php echo $_SESSION['RELATIVE_PATH'] ?>/IncidentesHW/BuscarIncidente.php';
                });
                $("#formulario").validate({
                    submitHandler: function (form) {
                        //if (verificarComponentes()) {
                            if (verificarFechas()) {
                                $(form).submit();
                            } else {
                                alert("Fecha y hora de incio es mayor que fecha y hora de fin");
                            }
//                        } else {
//                            alert("Seleccione al menos un componente");
//                        }
                    }
                });
                $("#ninguno").click(function (mievento) {
                    var ninguno = document.getElementById("ninguno");
                    if (ninguno.checked) {
                        document.getElementById("tipoComponente").disabled = true;
                        document.getElementById("accion").disabled = true;
                        document.getElementById("btnAgregar").disabled = true;
                        document.getElementById("btnAgregar").hidden = true;
                        document.getElementById("tablaCA").hidden = true;
                    } else {
                        document.getElementById("tipoComponente").disabled = false;
                        document.getElementById("accion").disabled = false;
                        document.getElementById("btnAgregar").disabled = false;
                        document.getElementById("btnAgregar").hidden = false;
                        document.getElementById("tablaCA").hidden = false;
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
                                        <input type="text" id="turno" name="turno" value="<?php echo utf8_encode($incidente['turno']) ?>" readonly="true"/>
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
                                <tr>
                                    <td>Probable componente afectado:</td>
                                    <td colspan="3">
                                        <input type="text" id="componenteAfectado" 
                                               name="componenteAfectado" value="<?php echo $incidente['tipo_componente'] ?>" 
                                               readonly="true"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Indicio de incidente:</td>
                                    <td colspan="3">
                                        <input type="text" id="causa" name="causa" 
                                               value="<?php echo $incidente['causa_incidente'] ?>" 
                                               readonly="true"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Reportó:</td>
                                    <td>
                                        <input type="text" id="reporto" name="reporto" 
                                               value="<?php echo $incidente['apellido_reporto'] ?>, <?php echo $incidente['nombre_reporto'] ?>" 
                                               readonly="true"/>
                                    </td>
                                    <td>Área:</td>
                                    <td>
                                        <input type="text" id="area" name="area" value="<?php echo $incidente['rol_reporto'] ?>" readonly="true"/>
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
                                    <td>Responsable 1:</td>
                                    <td>
                                        <input type="text" id="responsable1" name="responsable1" value="<?php echo $incidente['responsable1'] ?>" readonly="true"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nivel:</td>
                                    <td>
                                        <input type="text" id="fecha" name="fecha" value="<?php echo $incidente['nivel_actividad'] ?>" readonly="true"/>
                                    </td>
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
                        $queryDetalles = "SELECT DI.id_detalle_intervencion AS id, DI.descripcion, DI.fecha_inicio, DI.hora_inicio, DI.fecha_fin, DI.hora_fin, 
                        DI.motivo_no_finalizacion AS motivo, P.nombre, P.apellido
                        FROM detalle_intervencion DI 
                        INNER JOIN persona P ON P.id_persona = DI.id_persona_detalle_intervencion
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
                                    <fieldset><legend><h5>Intervención nro. <?php echo $idDetalle ?> - Reportado por: <?php echo $detalles['apellido'] . ", " . $detalles['nombre'] ?></h5></legend>
                                        <div class="archive-separator"></div>
                                        <table>
                                            <tr>
                                                <td>Fecha inicio:</td>
                                                <td>
                                                    <input type="text" id="finicioInterv<?php echo $idDetalle ?>" value="<?php echo formatoFecha::convertirAFechaSolaWeb($detalles['fecha_inicio']) ?>" readonly/>
                                                </td>
                                                <td>Hora inicio:</td>
                                                <td>
                                                    <input type="text" id="hinicioInterv<?php echo $idDetalle ?>" value="<?php echo substr($detalles['hora_inicio'], 0, 5) ?>" readonly/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Fecha fin:</td>
                                                <td>
                                                    <input type="text" id="ffinInterv<?php echo $idDetalle ?>" value="<?php echo formatoFecha::convertirAFechaSolaWeb($detalles['fecha_fin']) ?>" readonly/>
                                                </td>
                                                <td>Hora fin:</td>
                                                <td>
                                                    <input type="text" id="hfinInterv<?php echo $idDetalle ?>" value="<?php echo substr($detalles['hora_fin'], 0, 5) ?>" readonly="true"/>
                                                </td>
                                            </tr>
                                            <!-- aqui debe ir la consulta de los componentes-->
                                            <?php
                                            $queryComponentes = "SELECT TC.descripcion AS 'tipo_componente', C.descripcion, C.nro_patrimonio, 
                                                    C.nro_serie, M.descripcion AS 'marca', AC.nombre AS 'accion'
                                                    FROM detalle_intervencion DI 
                                                    INNER JOIN componentexdetalle_intervencion CXDI 
                                                    ON DI.id_detalle_intervencion = CXDI.id_detalle_intervencion 
                                                    AND DI.id_incidente = CXDI.id_incidente 
                                                    INNER JOIN componente C ON C.id_componente = CXDI.id_componente 
                                                    INNER JOIN tipo_componente TC ON C.id_tipo_componente = TC.id_tipo_componente 
                                                    INNER JOIN marca M ON M.id_marca = C.id_marca
                                                    INNER JOIN accion_correctiva AC ON AC.id_accion = CXDI.id_accion_correctiva
                                                    WHERE DI.id_detalle_intervencion = " . $detalles['id'] .
                                                    " AND DI.id_incidente = " . $id;
                                            //echo ''. $queryComponentes . '<br/>';
                                            $buscarComponentes = $mysqli->query($queryComponentes);
                                            echo '<tr>';
                                            echo '<td>Componentes afectado:</td>';
                                            echo '<td colspan="3">';
                                            if ($buscarComponentes && $mysqli->affected_rows > 0) {
                                                    ?>
                                                    <div>
                                                        <table class="listado2">
                                                            <thead>
                                                                <tr>
                                                                    <th>Componente</th>
                                                                    <th>Acci&oacute;n correctiva</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                while ($row = $buscarComponentes->fetch_assoc()) {
                                                                    print '<tr>';
                                                                    $combo = $row['tipo_componente'] . "-> " . $row['marca'];
                                                                    if ($row['nro_patrimonio'] != "" && $row['nro_patrimonio'] != null) {
                                                                        $combo .= " - Patrimonio: " . $row['nro_patrimonio'];
                                                                    } elseif ($row['ro_serie'] != "" && $row['nro_serie'] != null) {
                                                                        $combo .= " - Serie:" . $row['nro_serie'];
                                                                    } elseif ($row['descripcion'] != "" && $row['descripcion'] != null) {
                                                                        $combo .= " - Modelo:" . $row['descripcion'];
                                                                    }
                                                                    print '<td>';
                                                                    print '' . $combo;
                                                                    print '</td>';
                                                                    print '<td>';
                                                                    print '' . $row['accion'];
                                                                    print '</td>';
                                                                    print '</tr>';
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <?php
                                            }else{
                                                echo '<h5>No se realizo ninguna acción a ningún componente</h5>';
                                            }
                                            echo '</td></tr>';
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
                            <form id="formulario" name="formulario" method="post" action="registrarDI.php" class="contact_form">
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
                                                    <td>*Fecha inicio:</td>
                                                    <td>
                                                        <input type="text" id="finicio" name="finicio" value="" placeholder="__/__/__" required/>
                                                    </td>
                                                    <td>*Hora inicio:</td>
                                                    <td>
                                                        <input type="text" id="hinicio" name="hinicio" value="" placeholder="__:__" class="time" required/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>*Fecha fin:</td>
                                                    <td>
                                                        <input type="text" id="ffin" name="ffin" value="" placeholder="__/__/__"  required/>
                                                    </td>
                                                    <td>*Hora fin:</td>
                                                    <td>
                                                        <input type="text" id="hfin" name="hfin" value="" placeholder="__:__" class="time" required/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </fieldset>
                                    <fieldset><legend>Componente</legend>
                                        <div style="width: 800px;">
                                            <table id="componentesTratados">
                                                <tr>
                                                    <td>*Componenete tratado:</td>
                                                    <td>
                                                        <?php
                                                        $qComponentesSI = "SELECT C.id_componente AS 'id', TC.descripcion AS 'tipo_componente', 
                                                            C.descripcion, C.nro_patrimonio, C.nro_serie, M.descripcion AS 'marca'
                                                            FROM sistema_informatico SI 
                                                            INNER JOIN componente C ON C.id_sistema_informatico = SI.id_sistema_informatico 
                                                            INNER JOIN tipo_componente TC ON C.id_tipo_componente = TC.id_tipo_componente 
                                                            INNER JOIN marca M ON M.id_marca = C.id_marca
                                                            WHERE SI.id_sistema_informatico = " . $incidente['si'];
                                                        //echo $qComponentesSI."</br>";

                                                        print '<select name="tipoComponente" id="tipoComponente" required>';
                                                        print '<option value="">Seleccione...</option>';
                                                        $buscarComponenteSI = $mysqli->query($qComponentesSI);
                                                        if ($buscarComponenteSI) {
                                                            while ($row = $buscarComponenteSI->fetch_assoc()) {
                                                                //mostrar tipo_componente seguido de Marca y si tiene nro patrimonio, sino nro serie, sino descripcion
                                                                $combo = $row['tipo_componente'] . "-> " . $row['marca'];
                                                                if ($row['nro_patrimonio'] != "" && $row['nro_patrimonio'] != null) {
                                                                    $combo .= " - Patrimonio: " . $row['nro_patrimonio'];
                                                                } elseif ($row['nro_serie'] != "" && $row['nro_serie'] != null) {
                                                                    $combo .= " - Serie:" . $row['nro_serie'];
                                                                } elseif ($row['descripcion'] != "" && $row['descripcion'] != null) {
                                                                    $combo .= " - Modelo:" . $row['descripcion'];
                                                                }
                                                                print '<option value="' . $row['id'] . '">' . $combo . '</option>';
                                                            }
                                                        }
                                                        print '</select>';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div><input type="checkbox" name="ninguno" id="ninguno" value="0" class="componentes" style="height: 30px"/><label for="ninguno">Ninguno</label></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>*Accion correctiva<br/>realizada:</td>
                                                    <td colspan="2">
                                                        <select name="accion" id="accion" required>
                                                            <option value="">Seleccione...</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><button id="btnAgregar" >Agregar</button></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <div id="tablaCA">
                                                            <table class="listado2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Tipo de componente</th>
                                                                        <th>Acci&oacute;n correctiva</th>
                                                                        <th>Quitar</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Detalles:</td>
                                                    <td colspan="2">
                                                        <textarea cols="80" rows="8" name="descripcion"></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                    </fieldset>
                                    <!----------------------------------------------------------------------------------------------------------------------------->
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
                                    <input type="hidden" value="<?php echo $id ?>" name="nroIncidente"/>
                                    <!-- Por ultimo los botones-->
                                    <button class="submit" name="cancelar" id="cancelar">Cancelar</button>
                                    <button class="submit" name="registrar" type="submit" id="modificar">Registrar</button>
                                <?php } else { ?>
                                    <h4>Estado del Incidente: <?php echo $incidente['estado'] ?></h4>
                                    <button class="submit" name="volver" id="volver">Volver</button>
                                <?php } ?>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <?php include_once './../foot.php'; ?>
            </div>
        </div>
    </body>
</html>