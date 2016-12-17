<?php
session_start();
include_once '../verificarPermisos.php';
require_once '../formatoFecha.class.php';

try {
    $nroIncidente = filter_input(INPUT_POST, "nroIncidente");
    echo "nIncidente: " . $nroIncidente . "<br/>";
    echo "<br/>";
    $nroIntervencion = filter_input(INPUT_POST, "nroInterv");
    echo "nIntervencion: " . $nroIntervencion . "<br/>";
    echo "<br/>";
    $finicio = formatoFecha::convertirAFechaBD(filter_input(INPUT_POST, "finicio"));
    echo "fini: " . $finicio . "<br/>";
    echo "<br/>";
    $ffin = formatoFecha::convertirAFechaBD(filter_input(INPUT_POST, "ffin"));
    echo "ffin: " . $ffin. "<br/>";
    echo "<br/>";
    $hinicio = filter_input(INPUT_POST, "hinicio");
    echo "hinicio: " . $hinicio. "<br/>";
    echo "<br/>";
    $hfin = filter_input(INPUT_POST, "hfin");
    echo "hfin: " . $hfin. "<br/>";
    echo "<br/>";
    $ninguno = filter_input(INPUT_POST, "ninguno");
    echo "ninguno: " . $ninguno . "<br/>";
    echo "<br/>";
    $descripcion = filter_input(INPUT_POST, "descripcion");
    echo "descripcion:" . $descripcion;
    echo "<br/>";
    $estado = filter_input(INPUT_POST, "estado");
    echo "estado:" . $estado;
    echo "<br/>";
    $idPersona = $_SESSION['idPersona'];
    echo "idPer: " . $idPersona. "<br/>";
    echo "<br/>";
    
    require_once '../Conexion2.php';
    $mysqli->autocommit(FALSE);
    //hay que cargar primero la tabla accionycomponenteXdetalleIntervencion
    //luego crear el registro en detalleIntervencion
    $queryInsert = "INSERT INTO `detalle_intervencion`
        (`id_detalle_intervencion`,
        `id_incidente`,
        `descripcion`,
        `fecha_inicio`,
        `hora_inicio`,
        `fecha_fin`,
        `hora_fin`,
        `id_persona_detalle_intervencion`)
        VALUES
        (" . $nroIntervencion . ",
        " . $nroIncidente . ",
        \"" . $descripcion . "\",
        \"" . $finicio . "\",
        \"" . $hinicio . "\",
        \"" . $ffin . "\",
        \"" . $hfin . "\",
        " . $idPersona . ")";
    echo $queryInsert;
    echo "<br/>";
    if ($mysqli->query($queryInsert)) {
        if ($ninguno != "0") {
            echo 'entro en ninguno <br/>';
            $componentes = $_SESSION["componentes"];
            if($componentes != null){
                echo 'entro en no es nulo <br/>';
                foreach ($componentes as $row){
                    echo 'entro en el loop <br/>';
                    $queryComponente = "INSERT INTO componentexdetalle_intervencion
                        (`id_componente`,
                        `id_incidente`,
                        `id_detalle_intervencion`,
                        `id_causa`,
                        `id_accion_correctiva`)
                        VALUES
                        (" . $row['idComponente'] . ", "
                        . $nroIncidente . ", "
                        . $nroIntervencion .", "
                        . $row['idIndicio'] . ", "
                        . $row['idAccion'] . ")";
                    echo $queryComponente;
                    echo "<br/>";
                    if (!$mysqli->query($queryComponente)) {
                        throw new Exception ();
                    }
                }
            }else{
                throw new Exception ();
            }
        }
        //por ultimo actualizar el estado de Incidente
        $queryUpdate = "UPDATE incidente SET id_estado = " . $estado
                . " WHERE id_incidente = " . $nroIncidente;
        echo $queryUpdate;
        echo "<br/>";
        if ($mysqli->query($queryUpdate)) {
            printf($mysqli->affected_rows . " Filas afectadas<br/>");
            $mysqli->commit();
            $msj = 1;
        } else {
            throw new Exception ();
        }
    } else {
        throw new Exception ();
    }
} catch (Exception $ex) {
    $msj = 2;
    $mysqli->rollback();
}
//echo "<br/>msj: ". $msj;
//unset($_SESSION['componentes']);
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/IncidentesHW/InicioIncidentes.php?msj=' . $msj . '');
