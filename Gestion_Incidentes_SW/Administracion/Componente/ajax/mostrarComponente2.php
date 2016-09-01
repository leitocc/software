<?php

$idSala = filter_input(INPUT_POST, "idSala");
require_once '../../../Conexion2.php';
?>

<br/>
<br/>
<h5>Seleccione los componente software que desee Eliminar aula </h5>
<br/>
<br/>



<fieldset><legend>Componente</legend>
    <div style="float: left; width: 750px">
        <?php
        $query = "select cs.idComponente_Software AS ID ,CONCAT(cs.descripcion,'',IFNULL(cs.version,' ')) AS descripcionTotal
                  from componente_Software cs 
                  where cs.idComponente_software ";
        $resultado = $mysqli->query($query);
        while ($row = $resultado->fetch_assoc()) {
            ?>
            <div style="float: left; height: 30px">
                <input type="checkbox" name="cs[<?php echo $row['ID']; ?>]" class="Componente" value="<?php echo $row['ID'] ?>" id="cs[<?php echo $row['ID']; ?>]">
                <label for="cs[<?php echo $row['ID'] ?>]"> <?php echo $row['descripcionTotal'] ?> </label>
            </div>  
            <?php
        }
        ?>        
</fieldset>

