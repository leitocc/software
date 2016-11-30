<?php

$idSala = filter_input(INPUT_POST, "idSala");
require_once '../../../Conexion2.php';
?>
<h4>Seleccione los SI que desee asignar el componente general:</h4>
<fieldset><legend>Componente</legend>
    <div style="float: left; width: 750px">
        <div style="clear: right">
            <input type="checkbox" name="todos" class="Componente" id="todos" onclick="javascript:siTodos();">
            <label for="todos">TODOS</label>
        </div>
        <br/><br/>
        <div id="lista">
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
    </div>
</fieldset>
<h6>* ATENCION! El componente que sea del mismo tipo que ya este asignado a los Sistemas Informáticos seleccionados</h6>
<h6>se daran de baja automáticamente. Ej: Monitor, Teclado, Mouse, etc.</h6>
<h6>Esto no se aplica en componentes en los que puede haber m&aacute;s de uno por SI. Ej: Discos duros, RAM.</h6>