<?php
require_once '../../Conexion2.php';
$nombre = $_POST['nombre'];
$insertarAccion = "INSERT INTO accion_correctiva_software
    (`nombre`) VALUES (\"" . $nombre . "\");";
$resultadoAcciones = $mysqli->query($insertarAccion);
