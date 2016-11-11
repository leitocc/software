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
        <div style="clear: right">
            <input type="checkbox" name="todos" class="Componente" value="TODOS" id="todos">
            <label for="todos">Todos</label>
        </div>
        <br/><br/>
        <?php
        $query = "SELECT SI.id_sistema_informatico AS 'ISI' FROM sistema_informatico SI where SI.id_Sala = " . $idSala;
        $resultado = $mysqli->query($query);
        if($resultado){
            while ($row = $resultado->fetch_assoc()) {
                ?>
                <div style="float: left; height: 30px">
                    <input type="checkbox" name="SI[<?php echo $row['ISI']; ?>]" class="Componente" value="<?php echo $row['ISI'] ?>" id="SI[<?php echo $row['ISI']; ?>]">
                    <label for="SI[<?php echo $row['ISI'] ?>]"> <?php echo $row['ISI'] ?> </label>
                </div>  
                <?php
            }
        }
        ?>
    </div>
</fieldset>
<input type="checkbox" name="todos" id="todos" value="Seleccionar todos"/>

