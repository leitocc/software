<?php

require_once '../formatoFecha.class.php';
session_start();
try {
    require_once '../Conexion2.php';
    $nroIncidente = filter_input(INPUT_POST, "nroIncidente");
    $fecha = filter_input(INPUT_POST, "fecha");
    $fecha = formatoFecha::convertirAFechaBD($fecha);
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
    $preguntaAct = filter_input(INPUT_POST, "preguntaAct");
    if (isset($preguntaAct) && $preguntaAct === 1) {
        $nombreAct = filter_input(INPUT_POST, "nombreAct");
        $nivel = filter_input(INPUT_POST, "nivel");
        $responsable1 = filter_input(INPUT_POST, "responsable1");
        $responsable2 = filter_input(INPUT_POST, "responsable2");
        $idActividad['id'] = "si";
    } else {
        $idActividad['id'] = "NULL";
    }
} catch (Exception $ex) {
    echo $ex;
    echo $preguntaAct;
    die();
}

//primero debo insertar la actividad si es que hubo alguna
//echo $idActividad['id'];
//if ($idActividad['id'] != "NULL") {
//    $consultaIdAct = "SELECT MAX(A.id_actividad) AS id
//                     FROM actividad A";
//    $query2 = mysql_query($consultaIdAct);
//    if (mysql_errno() == 0) {
//        $idActividad = mysql_fetch_array($query2);
//    } else {
//        $idActividad['id'] = 0;
//    }
//    $idActividad['id'] ++;
//    $insertQuery = "INSERT INTO `actividad`
//                    (`id_actividad`,
//                    `nombre_actividad`,
//                    `nivel_actividad`,
//                    `responsable1`,
//                    `responsable2`)
//                    VALUES
//                    (" . $idActividad['id'] . ",
//                    \"" . $nombreAct . "\",
//                    " . $nivel . ",
//                    \"" . $responsable1 . "\",
//                    \"" . $responsable2 . "\")";
//    $insertActividad = mysql_query($insertQuery);
//    echo "Actividad: " . $insertQuery . "<br/><br/>";
//}



//se debe quietar el id persona que registro

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
        . $idActividad['id'] . ", " . $reporto . ", " . $prioridad . ", '" . $descripcion . "', " . $area . ");";
//$insert = mysql_query($insertQuery);
echo $insertQuery;
if ($mysqli->query($insertQuery) === TRUE) {
    echo "Incidentes: " . $mysqli->insert_id;
}

//mysqli_commit($insert);
/**/
if (mysql_errno() == 0) {
    header('Location: /IncidentesSoftware/Incidentes/InicioIncidentes.php?mjs=1');
} else {
    header('Location: /IncidentesSoftware/Incidentes/InicioIncidentes.php?mjs=0');
}

