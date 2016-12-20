<?php
require_once '../../Conexion2.php';
$idC = filter_input(INPUT_POST, "idCausa");
$qConsultaAccion = "SELECT AC.idAccion AS 'id', AC.nombre 
    FROM accion_softwarexcausa_software AXC
    INNER JOIN accion_correctiva_software AC ON AXC.id_accion = AC.idAccion
    WHERE AXC.id_causa = ". $idC;
$resultado = $mysqli->query($qConsultaAccion);
print '<option value="">Seleccione...</option>';
if ($resultado) {
    while ($row = $resultado->fetch_assoc()) {
        print '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
    }
}