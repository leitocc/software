<?php
require_once '../Conexion2.php';

$sala = $_POST['sala'];
$consultaSI = "select id_sistema_informatico from sistema_informatico where baja=0 and id_sala=" . $sala;
$query1 = $mysqli->query($consultaSI);
?>
<option value="">Seleccione...</option>
<?php while ($row = $query1->fetch_assoc()) { ?>
    <option value ="<?php echo $row['id_sistema_informatico'] ?>"><?php echo $row['id_sistema_informatico'] ?></option>
<?php } ?>