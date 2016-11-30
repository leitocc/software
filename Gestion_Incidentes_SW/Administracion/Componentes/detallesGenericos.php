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
    <label for="marca">Marca(*):</label>
    <select name="marca" id="marca" required>
        <option value="" >Seleccione...</option>
        <?php
        $resultado = $mysqli->query("select * from marca order by descripcion");
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
    <label for="modelo">Modelo(*):</label>
    <input name="modelo" id="modelo" type="text" maxlength="20" size="15" value="<?php echo $Comp->getDescripcion() ?>" required/>
</li>
<li>
    <label for="nroSerie">Nro. Serie:</label>
    <input name="nroSerie" id="nroSerie" type="text" size="30" maxlength="100" value="<?php echo $Comp->getNro_serie() ?>"/>
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
    <div name="inv"><input type="number" name="nroInventario" maxlength="7" size="6" id="nroInventario" value="<?php echo $Comp->getNro_patrimonio() ?>"></div>
</li>
<li>
    <label for="mes">Mes adquisición(*):</label>
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
    <label for="año">Año Adquisición(*):</label>
    <input type="number" id="año" name="año" maxlength="4" size="4" minlength="4" value="<?php echo $Comp->getAño() ?>" required/>
</li>
<?php
if (is_null($_SESSION['modo']) || $_SESSION['modo'] == 'ins') {
    switch ($idTC) {
        //monitor            
        case 1:
            print '<li>';
            print '<label for="tamaño">Medida (*):</label>';
            print '<input type="number" id="tamaño" name="tamaño" maxlength="2" size="2" required/>Pulgadas';
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
                print "<option value =" . $row['nombre'] . " >";
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
            print '<input type="number" id="capacidad" name="capacidad" maxlength="4" size="3" required/>GB';
            print '</li>';
            print '<li>';
            print '<label for="frecuencia">Frecuencia (*):</label>';
            print '<input type="number" id="frecuencia" name="frecuencia" maxlength="4" size="4" required/>MHz';
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
                print "<option value =" . $row['nombre'] . " >";
                print strtoupper($row['nombre']) . "</option>";
            }
            print '</select></li>';
            $resultado->free();
            print '<li>';
            print '<label for="velTransferencia">Velocidad de transferencia(*):</label>';
            print '<input type="number" name="velTransferencia" id="velTransferencia" maxlength="5" size="5" required/>Rpm';
            print'</li>';
            print '<li>';
            print '<label for="capacidad">Capacidad (*):</label>';
            print '<input type="number" id="capacidad" name="capacidad" maxlength="5" size="4" required/>GB';
            print'</li>';
            break;
        //placa de video
        case 8:
            print '<li>';
            print '<label for="capacidad">Capacidad de memoria (*):</label>';
            print '<input type="number" id="capacidad" name="capacidad" maxlength="5" size="4" required/>MB';
            print'</li>';
            break;
        //Placa Red
        case 9:
            print '<li>';
            print '<label for="mac">MAC (*):</label>';
            print '<input type="text" id="mac" name="mac" maxlength="17" size="17" placeholder="__:__:__:__:__:__" required/>';
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
            print '<input type="number" id="cantNucleo" name="cantNucleo" maxlength="2" size="2" required/>';
            print'</li>';
            print '<li>';
            print '<label for="velProcesamiento">Velocidad (*):</label>';
            print '<input type="number" id="velProcesamiento" name="velProcesamiento" maxlength="5" size="4" required/> Ghz';
            print '</li>';
            break;
        //fuente
        case 14:
            print '<li>';
            print '<label for="potencia">Potencia (*):</label>';
            print '<input type="number" id="potencia" name="potencia" maxlength="5" size="4" required/>Watts';
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
                    print '<input type="number" maxlength="5" size="5" name="velTransferencia" id="velTransferencia" value="' . $detalle->getValor() . '" required/>Rpm';
                    break;
                //Capacidad
                case 2:
                    //Si es disco duro o memoria
                    if ($idTC == 5 || $idTC == 6) {
                        print '<label for="capacidad">Capacidad (*):</label>';
                        print '<input type="number" value="' . $detalle->getValor() . '" id="capacidad" name="capacidad" maxlength="5" size="4" required/>GB';
                    } elseif ($idTC == 8) { //Si es Placa de video
                        print '<label for="capacidad">Capacidad de memoria (*):</label>';
                        print '<input type="number" value="' . $detalle->getValor() . '" id="capacidad" name="capacidad" maxlength="5" size="4" required/>MB';
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
                        print "<option value =" . $row['nombre'];
                        if($detalle->getValor_alfanumerico() == $row['nombre']){
                            print ' selected="true" ';
                        }
                        print " >";
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
                        print "<option value =" . $row['nombre'];
                        if($detalle->getValor_alfanumerico() == $row['nombre']){
                            print ' selected="true" ';
                        }
                        print " >";
                        print strtoupper($row['nombre']) . "</option>";
                    }
                    print '</select></li>';
                    $resultado->free();
                    break;
                //Tamaño
                case 5:
                    print '<label for="tamaño">Medida (*):</label>';
                    print '<input type="number" value="' . $detalle->getValor() . '" id="tamaño" name="tamaño" maxlength="2" size="2" required/>Pulgadas';
                    break;
                //Nucleos
                case 6:
                    print '<label for="cantNucleo">Cantidad  De Nucleo (*):</label>';
                    print '<input type="number" value="' . $detalle->getValor() . '" id="cantNucleo" name="cantNucleo" maxlength="2" size="2" required/>';
                    break;
                //Velocidad de procesamiento
                case 7:
                    print '<label for="velProcesamiento">Velocidad (*):</label>';
                    print '<input type="number" value="' . $detalle->getValor() . '" id="velProcesamiento" name="velProcesamiento" maxlength="5" size="4" required/> Ghz';
                    break;
                //Tipo de lectura
                case 8:
                    print '<label for="tipo_lectora">Tipo de Lectora (*):</label>';
                    $query = "select * from tipo_lectora";
                    $resultado = $mysqli->query($query);
                    print '<select name="tipo_lectora" id="tipo_lectora" required>';
                    print '<option value="" >Seleccione...</option>';
                    while ($row = $resultado->fetch_assoc()) {
                        print "<option value =" . $row['nombre'];
                        if($detalle->getValor_alfanumerico() == $row['nombre']){
                            print ' selected="true" ';
                        }
                        print " >";
                        print strtoupper($row['nombre']) . "</option>";
                    }
                    print '</select></li>';
                    $resultado->free();
                    break;
                //MAC
                case 10:
                    print '<label for="mac">MAC (*):</label>';
                    print '<td><input type="text" value="' . $detalle->getValor_alfanumerico() . '" id="mac" name="mac" maxlength="17" size="17" placeholder="__:__:__:__:__:__" required/>';
                    break;
                //Potencia
                case 11:
                    print '<label for="potencia">Potencia (*):</label>';
                    print '<input type="number" value="' . $detalle->getValor() . '" id="potencia" name="potencia" maxlength="5" size="4" required/>Watts';
                    break;
                //Frecuencia
                case 12:
                    print '<label for="frecuencia">Frecuencia (*):</label>';
                    print '<input type="number" value="' . $detalle->getValor() . '" id="frecuencia" name="frecuencia" maxlength="4" size="4" required/>MHz';
                    break;
                default:
                    print 'No se encontro tipo de detalle. Contactar al administrador';
            }
            print '</li>';
        }
    }
}