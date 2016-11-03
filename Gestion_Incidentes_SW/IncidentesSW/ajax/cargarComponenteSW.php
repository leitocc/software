<?php

require_once '../../Conexion2.php';
$componenteAfectado = $_POST['tipoSoftware'];
$qConsultaComponente = "SELECT concat(C.descripcion,' ',IFNULL(C.version,'')) as descripcionSoftware, 
    C.idComponente_Software AS id FROM componente_software C 
    WHERE C.id_tipo_componente = " . $componenteAfectado;
echo $qConsultaComponente;
$buscarComponente = $mysqli->query($qConsultaComponente);
print '<option value="">Seleccione...</option>';
if ($buscarComponente) {
    while ($row = $buscarComponente->fetch_assoc()) {
        print '<option value="' . $row['id'] . '">' . $row['descripcionSoftware'] . '</option>';
    }
}