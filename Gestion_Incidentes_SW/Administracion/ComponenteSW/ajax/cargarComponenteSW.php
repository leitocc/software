<?php
require_once '../../../Conexion2.php';
$id = filter_input(INPUT_POST, "id");
$query = "SELECT idComponente_Software AS 'id', descripcion, version, id_tipo_componente 
    FROM gestion_incidentes.componente_software 
    WHERE idComponente_Software = " . $id;
$consulta = $mysqli->query($query);
if ($consulta->num_rows > 0) {
    $componente = $consulta->fetch_assoc()
    ?>
    <li></li>
    <li>
        <label>(*)Nuevo nombre:</label> 
        <input name="descripcion" id="descripcion" type="text" value="<?php echo $componente['descripcion'] ?>">
    </li>
    <li>
        <label>(*)tipo componente</label>
        <select id="tipo_componente_software" name="tipo_componente_software"> 
            <option value="">Seleccione...</option>   
            <?php
            $query = "select tc.idtipocomponente AS id, tc.descripcion from tipo_componente_software tc";
            $resultado100 = $mysqli->query($query);
            if ($resultado100) {
                while ($row = $resultado100->fetch_assoc()) {
                    if ($row['id'] == $componente['id_tipo_componente']) {
                        ?>
                        <option value ="<?php echo $row['id'] ?>" selected="true"><?php echo $row['descripcion'] ?></option>
                        <?php
                    } else {
                        ?>
                        <option value ="<?php echo $row['id'] ?>"><?php echo $row['descripcion'] ?></option>
                        <?php
                    }
                }
            }
            ?>
        </select>         
    </li>
    <li>
        <label>( )Version</label>
        <input name="version" id="version" value="<?php echo $componente['version'] ?>"type="text"> 
    </li>
    <?php
}