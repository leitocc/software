<?php

session_start();
include_once '../verificarPermisos.php';

function paginaError($nroError, $msj) {
    header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/error.php?error=' . $nroError . '&msj=' . $msj . '');
    exit();
}

require_once '../formatoFecha.class.php';

try {
    $idIncidente = filter_input(INPUT_POST, "idIncidente");
    $fecha = filter_input(INPUT_POST, "fecha");
    $fecha = formatoFecha::convertirAFechaSolaBD($fecha);
    $hora = filter_input(INPUT_POST, "hora");
    //$tipoSoftware = filter_input(INPUT_POST, "tipoSoftware");
    $ninguno = filter_input(INPUT_POST, "ninguno");
    echo "ninguno: " . $ninguno . "<br/>";
    if($ninguno != 0){
        $softwareAfectado = filter_input(INPUT_POST, "softwareAfectado");
        $accion = filter_input(INPUT_POST, "accion");
    }else{
        $softwareAfectado = "NULL";
        $accion = 28; //id accion: No se realizo ninguna accion
    }
    $descripcion = filter_input(INPUT_POST, "descripcion");
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
        echo "nueva ComponenteXaula insertada " . $mysqli->insert_id . "<br/>";
    } else {
        echo "sql mal: " . $queryInsert . "<br/>";
        throw new Exception ();
        $mysqli->rollback();
        die();
    }
    $queryUpdate = "UPDATE `incidente_software` SET `id_estado` = ". $estado 
            . " WHERE `idIncidente` = " . $idIncidente;
    if ($mysqli->query($queryUpdate) === TRUE) {
        printf($mysqli->affected_rows ." Filas afectadas<br/>");
    }
    else{
        echo "Error al ejecutar el comando:".$mysqli->error;
        $mysqli->rollback();
        $mysqli->close();
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
//header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/Incidentes/InicioIncidentes.php?msj=1');
