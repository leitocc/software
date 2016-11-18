<?php
require_once '../../Conexion2.php';
$Comp = $_SESSION['componente'];
$Detalles = $_SESSION['detalles'];
$idTC = $_SESSION['idTC'];
require_once '../../Componente.class.php';
require_once '../../DetalleComponente.class.php';
?>
<li>
    <h3>Componente: </h3>
</li>
<li>
    <label for="marca">Marca:</label>
    <select name="marca" id="marca" required>
        <option value="" >Seleccione...</option>
        <?php
        $resultado = $mysqli->query("select * from marca");
        while ($row = $resultado->fetch_assoc()) {
            print '<option value ="' . $row['id_marca'] . '"';
            if ($row['id_marca'] == $Comp->getId_marca()) {
                echo 'selected="true"';
            }
            print '>' . $row['descripcion'] . '</option>';
        }
        ?>
    </select>
</li>
<li>
    <label for="modelo">Modelo:</label>
    <input name="modelo" id="modelo" type="text" maxlength="20" value="<?php echo $Comp->getDescripcion() ?>" required/>
</li>
<li>
    <label for="nroSerie">Nro. Serie:</label>
    <input name="nroSerie" id="nroSerie" type="text" size="50" maxlength="100" value="<?php echo $Comp->getNro_serie() ?>"/>
</li>
<li>
    <label for="inventariado">¿Esta inventariado?</label>
    <input type="radio" name="inventariado" id="invNO" value="no"> No
<?php
if ($Comp->getNro_patrimonio() != "") {
?>
        <input type="radio" name="inventariado" id="invSI" value="si" checked="true"> Si
<?php } else { ?>
        <input type="radio" name="inventariado" id="invSI" value="si"> Si
<?php } ?>
</li>

<li>
    <label for="inventariado">Nro. inventario:</label>
    <div name="inv"><input type="text" name="nroInventario" id="nroInventario" value="<?php echo $patrimonio ?>"></div>
</li>
<li>
    <label for="mes">Mes adquisición:</label>
    <select name="mes" id="mes" required>
        <option value="" >Seleccione...</option>
        <?php
        $mes = $Comp->getMes()
        ?>
        <option value="1" <?php
        if (1 == $mes) {
            echo 'selected="true"';
        }
        ?>> Enero</option>
        <option value="2" <?php
        if (2 == $mes) {
            echo 'selected="true"';
        }
        ?>> Febrero</option>
        <option value="3" <?php
        if (3 == $mes) {
            echo 'selected="true"';
        }
        ?>> Marzo</option>
        <option value="4" <?php
        if (4 == $mes) {
            echo 'selected="true"';
        }
        ?>> Abril</option>
        <option value="5" <?php
        if (5 == $mes) {
            echo 'selected="true"';
        }
        ?>> Mayo</option>
        <option value="6" <?php
        if (6 == $mes) {
            echo 'selected="true"';
        }
        ?>> Junio</option>
        <option value="7" <?php
        if (7 == $mes) {
            echo 'selected="true"';
        }
        ?>> Julio</option>
        <option value="8" <?php
        if (8 == $mes) {
            echo 'selected="true"';
        }
        ?>> Agosto</option>
        <option value="9" <?php
        if (9 == $mes) {
            echo 'selected="true"';
        }
        ?>> Septiembre</option>
        <option value="10" <?php
        if (10 == $mes) {
            echo 'selected="true"';
        }
        ?>> Octubre</option>
        <option value="11" <?php
        if (11 == $mes) {
            echo 'selected="true"';
        }
        ?>> Noviembre</option>
        <option value="12" <?php
        if (12 == $mes) {
            echo 'selected="true"';
        }
        ?>> Diciembre</option>
    </select>
</li>
<li>
    <label for="año">Año Adquisición:</label>
    <input id="año" name="año" value="<?php echo $Comp->getAño() ?>" required/>
</li>
<li>
    <label for="proveedor">Proveedor:</label>
    <?php $resultado = $mysqli->query("select * from proveedor"); ?>
    <select name='proveedor' id="proveedor"> 
        <option value="" >Seleccione...</option>
        <?php
        while ($row = $resultado->fetch_assoc()) {
            echo '<option value ="' . $row['id_proveedor'] . '">' . $row['nombre'] . '</option>';
        }
        ?>
    </select>
</li>
<?php
if (is_null($_SESSION['modo']) || $_SESSION['modo'] == 'ins') {
    print 'entro';
    switch ($idTC) {
        //monitor            
        case 1:
            print '<li>';
            print '<label for="tamaño">Medida (*):</label>';
            print '<input type="text" id="tamaño" name="tamaño" required/>Pulgadas';
            print '</li>';
        //mouse y teclado
        case 2:
        case 3:
            print '<li>';
            print '<label for="conexion">Tipo de conexión (*):</label>';
            $query = "select * from tipo_conexion";
            $resultado = $mysqli->query($query);
            print '<select name="conexion" id="conexion" required>';
            print '<option value="" >Seleccione...</option>';
            while ($row = $resultado->fetch_assoc()) {
                print "<option value =" . $row['id_tipo_conexion'] . " >";
                print strtoupper($row['nombre']) . "</option>";
            }
            print '</select></li>';
            $resultado->free();
            break;
        //Memoria RAM
        case 5:
            print '<li>';
            print '<label for="tipo_memoria">Tipo de memoria (*):</label>';
            $query = "select * from tipo_memoria";
            $resultado = $mysqli->query($query);
            print '<td><select name="tipo_memoria" id="tipo_memoria" required>';
            print '<option value="" >Seleccione...</option>';
            while ($row = $resultado->fetch_assoc()) {
                print "<option value =" . $row['id_tipo_memoria'] . " >";
                print strtoupper($row['nombre']) . "</option>";
            }
            print '</select></li>';
            $resultado->free();
            print '<li>';
            print '<label for="capacidad">Capacidad (*):</label>';
            print '<input type="text" id="capacidad" name="capacidad" required/>GB';
            print '</li>';
            print '<li>';
            print '<label for="frecuencia">Frecuencia (*):</label>';
            print '<input type="text" id="frecuencia" name="frecuencia" required/>Mhz';
            print '</li>';
            break;
        //Disco Duro
        case 6:
            print '<li>';
            print '<label for="conexion">Tipo de conexión (*):</label>';
            $query = "select * from tipo_conexion";
            $resultado = $mysqli->query($query);
            print '<select name="conexion" id="conexion" required>';
            print '<option value="" >Seleccione...</option>';
            while ($row = $resultado->fetch_assoc()) {
                print "<option value =" . $row['id_tipo_conexion'] . " >";
                print strtoupper($row['nombre']) . "</option>";
            }
            print '</select></li>';
            $resultado->free();
            print '<li>';
            print '<label for="velTransferencia">Velocidad de transferencia(*):</label>';
            print '<input type="text" name="velTransferencia" required/>Rpm';
            print'</li>';
            print '<li>';
            print '<label for="capacidad">Capacidad (*):</label>';
            print '<input type="text" id="capacidad" name="capacidad" required/>GB';
            print'</li>';
            break;
        //placa de video
        case 8:
            print '<li>';
            print '<label for="capacidad">Capacidad de memoria (*):</label>';
            print '<input type="text" id="capacidad" name="capacidad" required/>MB';
            print'</li>';
            break;
        //Placa Red
        case 9:
            print '<li>';
            print '<label for="mac">MAC (*):</label>';
            print '<td><input type="text" id="mac" name="mac" required/>';
            print'</li>';
            break;
        //Placa Audio 10 no tiene detalles
        //lectora    
        case 11:
            print '<li>';
            print '<label for="tipo_lectora">Tipo de Lectora (*):</label>';
            $query = "select * from tipo_lectora";
            $resultado = $mysqli->query($query);
            print '<select name="tipo_lectora" id="tipo_lectora" required>';
            print '<option value="" >Seleccione...</option>';
            while ($row = $resultado->fetch_assoc()) {
                print "<option value =" . $row['id_tipo_lectora'] . " >";
                print strtoupper($row['nombre']) . "</option>";
            }
            print '</select></li>';
            $resultado->free();
            break;
        //MicroProcesador    
        case 13:
            print '<li>';
            print '<label for="cantNucleo">Cantidad  De Nucleo (*):</label>';
            print '<input type="text" id="cantNucleo" name="cantNucleo" required/>';
            print'</li>';
            print '<li>';
            print '<label for="velProcesamiento">Velocidad (*):</label>';
            print '<input type="text" id="velProcesamiento" name="velProcesamiento" required/> Ghz';
            print '</li>';
            break;
        //fuente
        case 14:
            print '<li>';
            print '<label for="potencia">Potencia (*):</label>';
            print '<input type="text" id="potencia" name="potencia" required/>Watts';
            print '</li>';
            break;
        default:
            break;
    }
} else {
    if (!is_null($Detalles)) {
        //segun el tipo de descripcion de detalle sera el campo que se visualice
        foreach ($Detalles as $detalle) {
            print '<li>';
            switch ($detalle->getId_descripcion()) {
                //Velocidad de transferencia
                case 1:
                    print '<label for="velTransferencia">Velocidad de transferencia(*):</label>';
                    print '<input type="text" name="velTransferencia" required/>Rpm';
                    break;
                //Capacidad
                case 2:
                    //Si es disco duro
                    if ($idTC == 5 || $idTC == 6) {
                        print '<label for="capacidad">Capacidad (*):</label>';
                        print '<input type="text" id="capacidad" name="capacidad" required/>GB';
                    } elseif ($idTC == 8) { //Si es Placa de video
                        print '<label for="capacidad">Capacidad de memoria (*):</label>';
                        print '<input type="text" id="capacidad" name="capacidad" required/>MB';
                    } else {
                        print 'No se encontro tipo de detalle. Contactar al administrador';
                    }
                    break;
                //Tipo de conexion
                case 3:
                    print '<label for="conexion">Tipo de conexión (*):</label>';
                    $query = "select * from tipo_conexion";
                    $resultado = $mysqli->query($query);
                    print '<select name="conexion" id="conexion" required>';
                    print '<option value="" >Seleccione...</option>';
                    while ($row = $resultado->fetch_assoc()) {
                        print "<option value =" . $row['id_tipo_conexion'] . " >";
                        print strtoupper($row['nombre']) . "</option>";
                    }
                    print '</select></li>';
                    $resultado->free();
                    break;
                //Tipo de memoria
                case 4:
                    print '<label for="tipo_memoria">Tipo de memoria (*):</label>';
                    $query = "select * from tipo_memoria";
                    $resultado = $mysqli->query($query);
                    print '<td><select name="tipo_memoria" id="tipo_memoria" required>';
                    print '<option value="" >Seleccione...</option>';
                    while ($row = $resultado->fetch_assoc()) {
                        print "<option value =" . $row['id_tipo_memoria'] . " >";
                        print strtoupper($row['nombre']) . "</option>";
                    }
                    print '</select></li>';
                    $resultado->free();
                    break;
                //Tamaño
                case 5:
                    print '<label for="tamaño">Medida (*):</label>';
                    print '<input type="text" id="tamaño" name="tamaño" required/>Pulgadas';
                    break;
                //Nucleos
                case 6:
                    print '<label for="cantNucleo">Cantidad  De Nucleo (*):</label>';
                    print '<input type="text" id="cantNucleo" name="cantNucleo" required/>';
                    break;
                //Velocidad de procesamiento
                case 7:
                    print '<label for="velProcesamiento">Velocidad (*):</label>';
                    print '<input type="text" id="velProcesamiento" name="velProcesamiento" required/> Ghz';
                    break;
                //Tipo de lectura
                case 8:
                    print '<label for="tipo_lectora">Tipo de Lectora (*):</label>';
                    $query = "select * from tipo_lectora";
                    $resultado = $mysqli->query($query);
                    print '<select name="tipo_lectora" id="tipo_lectora" required>';
                    print '<option value="" >Seleccione...</option>';
                    while ($row = $resultado->fetch_assoc()) {
                        print "<option value =" . $row['id_tipo_lectora'] . " >";
                        print strtoupper($row['nombre']) . "</option>";
                    }
                    print '</select></li>';
                    $resultado->free();
                    break;
                //MAC
                case 10:
                    print '<label for="mac">MAC (*):</label>';
                    print '<td><input type="text" id="mac" name="mac" required/>';
                    break;
                //Potencia
                case 11:
                    print '<label for="potencia">Potencia (*):</label>';
                    print '<input type="text" id="potencia" name="potencia" required/>Watts';
                    break;
                //Frecuencia
                case 12:
                    print '<label for="frecuencia">Frecuencia (*):</label>';
                    print '<input type="text" id="frecuencia" name="frecuencia" required/>Mhz';
                    break;
                default:
                    print 'No se encontro tipo de detalle. Contactar al administrador';
            }
            print '</li>';
        }
    }
}