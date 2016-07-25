<?php
$idSala = filter_input(INPUT_POST, "idSala");
require_once '../../Conexion2.php';
?>
<br/>
<br/>
<h5>Seleccione los SI que desee asignar el componente general:</h5>
<br/>
<br/>

<fieldset><legend>Componente</legend>
    <div style="float: left; width: 750px">
        <?php
        $query = "SELECT SI.id_sistema_informatico AS ISI FROM Sistema_Informatico SI where SI.id_Sala = " . $idSala;
        $resultado = $mysqli->query($query);
        while ($row = $resultado->fetch_assoc()) {
            ?>
            <div style="float: left; height: 30px">
                <input type="checkbox" name="SI[<?php echo $row['ISI']; ?>]" class="Componente" value="<?php echo $row['ISI'] ?>" id="SI[<?php echo $row['ISI']; ?>]">
                <label for="SI[<?php echo $row['ISI'] ?>]"> <?php echo $row['ISI'] ?> </label>
            </div>  
            <?php
        }
        ?>
        <div><button class="submitComponente" align="left" type="button" name="agregarSistemaInformatico" id="agregarSI">Agregar Sistema Informatico</button></div>
        <label for="todos">Seleccionar todos</label><br/><br/><br/>
</fieldset>
<input type="checkbox" name="todos" id="todos" value="Seleccionar todos"/>

