<?php
require_once '../../Conexion2.php';
//ver esta algo mal aca

$componenteAfectado = filter_input(INPUT_POST, "componenteAfectado");
$queryconsultaComponente = "Select IT.id_Indicio, CI.nombre From indicioxtipo_componente IT INNER JOIN causa_incidente CI on IT.id_indicio = CI.id_tipo_incidente where IT.id_tipo_componente = " . $componenteAfectado;
$resultado = $mysqli->query($queryconsultaComponente);
?>
<option value="">Seleccione...</option>
<?php while ($row = $resultado->fetch_assoc()) { ?>
    <option value ="<?php echo $row['id_Indicio'] ?>"><?php echo $row['nombre'] ?></option>
<?php }


