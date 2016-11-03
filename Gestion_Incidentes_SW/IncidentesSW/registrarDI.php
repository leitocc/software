<?php

session_start();
include_once '../verificarPermisos.php';
require_once '../formatoFecha.class.php';
try {
    $idIncidente = filter_input(INPUT_POST, "idIncidente");
    $fecha = filter_input(INPUT_POST, "fecha");
    $fecha = formatoFecha::convertirAFechaSolaBD($fecha);
    $hora = filter_input(INPUT_POST, "hora");
    $ninguno = filter_input(INPUT_POST, "ninguno");
    if ($ninguno == "0") {
        $softwareAfectado = "NULL";
        $accion = 28; //id accion: No se realizo ninguna accion
    } else {
        $softwareAfectado = filter_input(INPUT_POST, "softwareAfectado");
        $accion = filter_input(INPUT_POST, "accion");
    }
    $descripcion = filter_input(INPUT_POST, "descripcion");
    $estado = filter_input(INPUT_POST, "estado");

    echo "ninguno: " . $ninguno . "<br/>";
    echo "<br/>";
    echo "id: " . $idIncidente;
    echo "<br/>";
    echo "fecha:" . $fecha;
    echo "<br/>";
    echo "hora:" . $hora;
    echo "<br/>";
    echo "descripcion:" . $descripcion;
    echo "<br/>";
    echo "estado:" . $estado;
    echo "<br/>";
    echo "soft:" . $softwareAfectado;
    echo "<br/>";
    echo "accion:" . $accion;
    echo "<br/>";

    require_once '../Conexion2.php';

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
    echo $queryInsert;
    echo "<br/>";
    if ($mysqli->query($queryInsert)) {
        echo "nueva ComponenteXaula insertada " . $mysqli->insert_id . "<br/>";
        echo "<br/>";
        $queryUpdate = "UPDATE `incidente_software` SET `id_estado` = " . $estado
                . " WHERE `idIncidente` = " . $idIncidente;
        echo $queryUpdate;
        echo "<br/>";
        if ($mysqli->query($queryUpdate)) {
            printf($mysqli->affected_rows . " Filas afectadas<br/>");
            $mysqli->commit();
            $msj = 1;
        } else {
            echo "Error al ejecutar el comando:" . $mysqli->error;
            throw new Exception ();
            //        die();
        }
    } else {
        echo "sql mal: " . $queryInsert . "<br/>";
        throw new Exception ();
//        die();
    }
} catch (Exception $ex) {
    $msj = 2;
    $mysqli->rollback();
    //header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/IncidentesSW/InicioIncidentes.php?msj=' . $msj . '');
//    echo "<br/>";
//    echo "Msj: " . $msj;
//    die();
}

header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/IncidentesSW/InicioIncidentes.php?msj=' . $msj . '');
//echo "<br/>";
//echo "Msj: " . $msj;
