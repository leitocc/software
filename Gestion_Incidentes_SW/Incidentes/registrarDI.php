<?php

session_start();
echo "usuario: " . $_SESSION['idPersona'] . "<br/>";

function paginaError($nroError, $mjs) {
    header('Location: /IncidentesSoftware/error.php?error=' . $nroError . '&mjs=' . $mjs . '');
    exit();
}

require_once '../formatoFecha.class.php';

try {
    $idIncidente = filter_input(INPUT_POST, "idIncidente");
    $fecha = filter_input(INPUT_POST, "fecha");
    $fecha = formatoFecha::convertirAFechaSolaBD($fecha);
    $hora = filter_input(INPUT_POST, "hora");
    //$tipoSoftware = filter_input(INPUT_POST, "tipoSoftware");
    $softwareAfectado = filter_input(INPUT_POST, "softwareAfectado");
    $ninguno = filter_input(INPUT_POST, "ninguno");
    $descripcion = filter_input(INPUT_POST, "descripcion");
    $accion = filter_input(INPUT_POST, "accion");
    $estado = filter_input(INPUT_POST, "estado");
} catch (Exception $ex) {
    echo "se rompio por aqui<br/>";
    header('Location: /incidentes/ErrorFormulario.php');
}

require_once '../Conexion2.php';

$consultaReporto = "SELECT P.id_persona AS id 
FROM persona P INNER JOIN usuario U ON P.id_persona = U.id_persona 
AND U.usuario = \"" . $_SESSION['usuario'] . "\"";
$queryUsuario = mysql_query($consultaReporto);
$idPersona = "NULL";
if (mysql_errno() == 0) {
    if ($row = mysql_fetch_array($queryUsuario)) {
        $idPersona = $row['id'];
    }
}

try {
    $mysqli->autocommit(FALSE);

    
    
    $queryInsert = "INSERT INTO `detalle_intervencion_software`
            (`id_incidente`,
            `id_responsable`,
            `id_accion`,
            `id_componente_software`,
            `fecha_inicio`,
            `hora_inicio`,
            `descripcion`)
            VALUES
            (" . $idIncidente . ","
            . $_SESSION['idPersona'] . ","
            . $accion . ","
            . $softwareAfectado . ",'"
            . $fecha . "','"
            . $hora . "','"
            . $descripcion . "');";
    if ($mysqli->query($queryInsert) === TRUE) {
        echo "nueva ComponenteXaula insertada " . $mysqli->insert_id;
    } else {
        echo "sql: " . $queryInsert . "<br/>";
        throw new Exception ();
        $mysqli->rollback();
        die();
    }
} catch (Exception $ex) {

    echo "todo mal: " . $e;
    $mysqli->rollback();
    $mysqli->close();
    die();
}

$mysqli->commit();
$mysqli->close();
//header('Location: /IncidentesSoftware/Incidentes/InicioIncidentes.php?mjs=1');
