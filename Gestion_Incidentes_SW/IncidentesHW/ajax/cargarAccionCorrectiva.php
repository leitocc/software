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
        $qConsultaAccion = "SELECT AXTC.id_accion_correctiva AS 'id', A.nombre 
    FROM accion_correctivaxtipo_componente AXTC 
    INNER JOIN accion_correctiva A ON A.id_accion = AXTC.id_accion_correctiva 
    WHERE AXTC.id_tipo_componente = " . $id;
        $buscarAcciones = $mysqli->query($qConsultaAccion);
        print '<option value="">Seleccione...</option>';
        if ($buscarAcciones) {
            while ($row = $buscarAcciones->fetch_assoc()) {
                print '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
            }
        }
        break;
    }
}