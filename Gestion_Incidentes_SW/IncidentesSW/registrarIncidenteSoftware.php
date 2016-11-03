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
    $causaIncidente = filter_input(INPUT_POST, "causaIncidente");
    $prioridad = filter_input(INPUT_POST, "prioridad");
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
        if(($responsable1) == ""){
            $responsable1 = "NULL";
        }
        if(($responsable2) == ""){
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
    $insertQuery = "INSERT INTO incidente_software
        (id_sistema_informatico,
        fecha,
        id_turno,
        id_causa_incidente,
        id_estado,
        id_actividad_desarollo,
        id_persona_reporte,
        id_prioridad,
        descripcion,
        id_rol_persona_reporte)
        VALUES(" . $si . ",\"" . $fecha . "\", " . $turno . ", " . $causaIncidente . ",1, "
            . $idActividad . ", " . $reporto . ", " . $prioridad . ", '" . $descripcion . "', " . $area . ");";
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
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/IncidentesSW/InicioIncidentes.php?msj=' . $msj . '');