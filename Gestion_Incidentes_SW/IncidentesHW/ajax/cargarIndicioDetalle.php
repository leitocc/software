<?php

require_once '../../Conexion2.php';
$combo = filter_input(INPUT_POST, "tipoComponente");
$vectorCombo = explode("-", $combo);
$componenteAfectado = $vectorCombo[0];

$qConsulta = "SELECT id_tipo_componente AS 'id' FROM tipo_componente
WHERE descripcion = \"" . $componenteAfectado . "\"";

$resultado = $mysqli->query($qConsulta);
if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $id = $row['id'];
        $queryconsultaComponente = "Select IT.id_Indicio AS 'id', CI.nombre "
                . "From indicioxtipo_componente IT "
                . "INNER JOIN causa_incidente CI on IT.id_indicio = CI.id_tipo_incidente "
                . "where IT.id_tipo_componente = " . $id;
        $buscarIndicios = $mysqli->query($queryconsultaComponente);
        print '<option value="">Seleccione...</option>';
        if ($buscarIndicios) {
            while ($row = $buscarIndicios->fetch_assoc()) {
                print '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
            }
        }
        break;
    }
}