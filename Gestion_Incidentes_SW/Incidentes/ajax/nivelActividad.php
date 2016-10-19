<?php
$id_tipo_actividad = filter_input(INPUT_POST, "id");
require_once '../../Conexion2.php';
$consultaActividad = "SELECT nivel_actividad "
        . "FROM tipo_actividad "
        . "WHERE id_tipo_actividad = " . $id_tipo_actividad;
$resultadoNivel = $mysqli->query($consultaActividad);
if ($resultadoNivel) {
    $row = $resultadoNivel->fetch_assoc();
    echo $row['nivel_actividad'];
}else{
    echo '';
}