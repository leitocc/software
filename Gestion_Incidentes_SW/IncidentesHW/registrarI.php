<?php

require_once '../formatoFecha.class.php';
session_start();
try {
    require_once '../Conexion2.php';
    $nroIncidente = filter_input(INPUT_POST, "nroIncidente");
    $fecha = formatoFecha::convertirAFechaBD(filter_input(INPUT_POST, "fecha"));
    $turno = filter_input(INPUT_POST, "turno");
    $institucion = filter_input(INPUT_POST, "institucion");
    $edificio = filter_input(INPUT_POST, "edificio");
    $sala = filter_input(INPUT_POST, "sala");
    $si = filter_input(INPUT_POST, "si");
    $componenteAfectado = filter_input(INPUT_POST, "componenteAfectado");
    $indicio = filter_input(INPUT_POST, "indicio");
    $reporto = filter_input(INPUT_POST, "reporto");
    $area = filter_input(INPUT_POST, "area");
    $descripcion = filter_input(INPUT_POST, "descripcion");
    $idActividad = "NULL";
    $mysqli->autocommit(FALSE);
    $preguntaAct = filter_input(INPUT_POST, "preguntaAct");
    echo $preguntaAct;
    echo "<br/>";
    if (isset($preguntaAct) && $preguntaAct == 1) {
        echo "entro??";
        echo "<br/>";
        $idTipoActividad = filter_input(INPUT_POST, "nombreAct");
        $responsable1 = filter_input(INPUT_POST, "responsable1");
        $responsable2 = filter_input(INPUT_POST, "responsable2");
        if (($responsable1) == "") {
            $responsable1 = "NULL";
        }
        if (($responsable2) == "") {
            $responsable2 = "NULL";
        }
        $actQuery = "INSERT INTO actividad
            (`tipo_nombre_actividad`,
            `responsable1`,
            `responsable2`)
            VALUES
            (" . $idTipoActividad . ",\"" . $responsable1 . "\", \"" . $responsable2 . "\");";
        echo $actQuery . "<br/>";
        if (!$mysqli->query($actQuery)) {
            throw new Exception ();
        }
        $idActividad = $mysqli->insert_id;
    }
    $insertQuery = "INSERT INTO incidente
        (`id_sistema_informatico_afectado`,
        `fecha`,
        `id_turno`,
        `id_sala`,
        `descripcion`,
        `id_causa_incidente`,
        `id_estado`,
        `id_actividad_en_desarrollo`,
        `id_persona_reporto`,
        `id_rol_persona_reporto`,
        `id_tipo_componente_afectado`)
        VALUES(" . $si . ",\"" . $fecha . "\", " . $turno . ", " . $sala . ", '" . $descripcion
            . "', " . $indicio . ",1, " . $idActividad . ", " . $reporto . ", " . $area . ", " . $componenteAfectado . ");";
    echo $insertQuery . "<br/>";
    if ($mysqli->query($insertQuery)) {
        $msj = 1;
        $mysqli->commit();
        echo "Incidentes: " . $mysqli->insert_id;
    } else {
        throw new Exception ();
    }
} catch (Exception $ex) {
    $msj = 2;
    $mysqli->rollback();
}
echo "<br/>Msj: " . $msj;
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/IncidentesHW/InicioIncidentes.php?msj=' . $msj . '');