<?php
require_once '../../Conexion2.php';


$componenteAfectado = $_POST['componenteAfectado'];
$queryconsultaComponente = "Select IT.id_Indicio, CI.nombre From IndicioxTipo_componente IT INNER JOIN causa_incidente CI on IT.id_indicio=CI.id_tipo_incidente where It.id_tipo_componente=" .$componenteAfectado;
$query14 = $mysqli->query($queryconsultaComponente);
?>
    <option value="">Seleccione...</option>
<?php while ($row = $query14->fetch_assoc()) { ?>
    <option value ="<?php echo $row['id_Indicio'] ?>"><?php echo $row['nombre'] ?></option>
<?php } ?>


