<?php
$idSala = filter_input(INPUT_POST, "idSala");
require_once '../../../Conexion2.php';
?>
<h4>Seleccione los componente software que desee asignar aula </h4>
<fieldset><legend>Componente</legend>
    <div style="float: left; width: 750px">
        <?php
        $query = "select cs.idComponente_Software AS ID ,CONCAT(cs.descripcion,'',IFNULL(cs.version,' ')) AS descripcionTotal
                  from componente_software cs 
                  where cs.idComponente_software NOT IN (select ss.idComponente_software 
                                                         FROM componente_software ss INNER JOIN salaxcomponente_software sxc on ss.idComponente_software=sxc.id_componente_software 
                                                         where sxc.id_sala=".$idSala.");";
        //echo $query . "<br/>";
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
    </div>
</fieldset>


