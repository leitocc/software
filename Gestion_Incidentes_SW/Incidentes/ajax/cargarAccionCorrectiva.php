<?php
require_once '../../Conexion2.php';
$componenteAfectado = $_POST['tipoComponente'];
$qConsultaAccion = "SELECT AXTC.id_accion_correctiva AS id, A.nombre 
FROM accion_correctivaxtipo_componente AXTC 
INNER JOIN accion_correctiva A ON A.id_accion = AXTC.id_accion_correctiva 
WHERE AXTC.id_tipo_componente = ". $componenteAfectado;
$buscarAcciones = $mysqli->query($qConsultaAccion);
print '<option value="">Seleccione...</option>';
if ($buscarAcciones) {
    while ($row = $buscarAcciones->fetch_assoc()) {
        print '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
    }
}