
<?php
require_once '../../../Conexion2.php';
$idTC = filter_input(INPUT_POST, "idTipoComponente");
?>
<li>
    <h3>Ingrese los datos del componente: </h3>
</li>
<li>
    <label for="marca">Marca(*):</label>
    <select name="marca" id="marca" required>
        <option value="" >Seleccione...</option>
        <?php
        $resultado = $mysqli->query("select * from marca order by descripcion");
        while ($row = $resultado->fetch_assoc()) {
            print '<option value ="' . $row['id_marca'] . '"';
            print '>' . $row['descripcion'] . '</option>';
        }
        ?>
    </select>
</li>
<li>
    <label for="modelo">Modelo(*):</label>
    <input name="modelo" id="modelo" type="text" maxlength="20" size="15" required/>
</li>
<li>
    <label for="mes">Mes adquisición(*):</label>
    <select name="mes" id="mes" required>
        <?php
        print '<option value="">Seleccione...</option>';
        print '<option value="1">Enero</option>';
        print '<option value="2">Febrero</option>';
        print '<option value="3">Marzo</option>';
        print '<option value="4">Abril</option>';
        print '<option value="5">Mayo</option>';
        print '<option value="6">Junio</option>';
        print '<option value="7">Julio</option>';
        print '<option value="8">Agosto</option>';
        print '<option value="9">Septiembre</option>';
        print '<option value="10">Octubre</option>';
        print '<option value="11">Noviembre</option>';
        print '<option value="12">Diciembre</option>';
        ?>
    </select>
</li>
<li>
    <label for="año">Año Adquisición(*):</label>
    <input type="number" id="año" name="año" maxlength="4" size="4" minlength="4" required/>
</li>
<?php
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



//print '<table><tr>';
//print '<td>Marca:</td>';
//$query = "select * from marca order by descripcion";
//$resultado = $mysqli->query($query);
//print '<td><select name="marca" id="marca" required>';
//print '<option value="" >Seleccione...</option>';
//while ($row = $resultado->fetch_assoc()) {
//    print "<option value =\"" . $row['id_marca'] . "\" >";
//    print $row['descripcion'] . "</option>";
//}
//print '</select></td>';
//$resultado->free();
//print '</tr><tr>';
//print '<td>Modelo:</td>';
//print '<td><input name="modelo" id="modelo"/><td/>';
//print '</tr><tr>';
//print '<td>Mes de adquisicion </td>';
//print '<td><select name="mes" id="mes" required>';
//print '<option value="">Seleccione...</option>';
//print '<option value="1">Enero</option>';
//print '<option value="2">Febrero</option>';
//print '<option value="3">Marzo</option>';
//print '<option value="4">Abril</option>';
//print '<option value="5">Mayo</option>';
//print '<option value="6">Junio</option>';
//print '<option value="7">Julio</option>';
//print '<option value="8">Agosto</option>';
//print '<option value="9">Septiembre</option>';
//print '<option value="10">Octubre</option>';
//print '<option value="11">Noviembre</option>';
//print '<option value="12">Diciembre</option>';
//print '</select></td>';
//print '</tr><tr>';
//print '<td>Año adquisición</td>';
//print '<td><input id="anio" name="anio" required/></td>';
//print '</tr>';
//
///*
// * Aqui se colocan los detalles especificos segun tipo componente
// */
//
//
//
//switch ($idTC) {
//    case 1:
//        //monitor
//        print '<tr><td>Tipo de conexion (*)</td>';
//        $query = "select * from tipo_conexion";
//        $resultado = $mysqli->query($query);
//        print '<td><select name="conexion" id="conexion" required>';
//        print '<option value="" >Seleccione...</option>';
//        while ($row = $resultado->fetch_assoc()) {
//            print "<option value =" . $row['nombre'] . " >";
//            print strtoupper($row['nombre']) . "</option>";
//        }
//        print '</select></td></tr>';
//        $resultado->free();
//        print '<tr><td>Medida (*)</td>';
//        print '<td><input type="text" id="tamaño" name="tamaño" required/>Pulgadas</td>';
//        print '</tr>';
//        break;
//    case 2:
//        //mouse
//        print '<tr><td>Tipo de conexion (*)</td>';
//        $query = "select * from tipo_conexion";
//        $resultado = $mysqli->query($query);
//        print '<td><select name="conexion" id="conexion" required>';
//        print '<option value="" >Seleccione...</option>';
//        while ($row = $resultado->fetch_assoc()) {
//            print "<option value =" . $row['nombre'] . " >";
//            print strtoupper($row['nombre']) . "</option>";
//        }
//        print '</select></td></tr>';
//        $resultado->free();
//        break;
//    //teclado
//    case 3:
//        print '<tr><td>Tipo de conexion (*)</td>';
//        $query = "select * from tipo_conexion";
//        $resultado = $mysqli->query($query);
//        print '<td><select name="conexion" id="conexion" required>';
//        print '<option value="" >Seleccione...</option>';
//        while ($row = $resultado->fetch_assoc()) {
//            print "<option value =" . $row['nombre'] . " >";
//            print strtoupper($row['nombre']) . "</option>";
//        }
//        print '</select></td></tr>';
//        $resultado->free();
//        break;
//    //Memoria RAM
//    case 5:
//        print '<tr><td>Tipo de memoria (*)</td>';
//        $query = "select * from tipo_memoria";
//        $resultado = $mysqli->query($query);
//        print '<td><select name="tipo_memoria" id="tipo_memoria" required>';
//        print '<option value="" >Seleccione...</option>';
//        while ($row = $resultado->fetch_assoc()) {
//            print "<option value =" . $row['nombre'] . " >";
//            print strtoupper($row['nombre']) . "</option>";
//        }
//        print '</select></td></tr>';
//        $resultado->free();
//        print '<tr><td>Capacidad</td>';
//        print '<td><input type="text" id="capacidad" name="capacidad" required/>GB</td>';
//        print '</tr>';
//        print '<tr><td>Frecuencia</td>';
//        print '<td><input type="text" id="frecuencia" name="frecuencia" required/>Mhz</td>';
//        print '</tr>';
//        break;
//    //Disco Duro
//    case 6:
//        print '<tr><td>Tipo de conexion (*)</td>';
//        $query = "select * from tipo_conexion";
//        $resultado = $mysqli->query($query);
//        print '<td><select name="conexion" id="conexion" required>';
//        print '<option value="" >Seleccione...</option>';
//        while ($row = $resultado->fetch_assoc()) {
//            print "<option value =" . $row['nombre'] . " >";
//            print strtoupper($row['nombre']) . "</option>";
//        }
//        print '</select></td></tr>';
//        $resultado->free();
//        print '<tr><td>Velocidad de transferencia(*)</td>';
//        print '<td><input type="text" id="velTransferencia" name="velTransferencia" required/>Rpm</td>';
//        print'</tr>';
//        print '<tr><td>Capacidad</td>';
//        print '<td><input type="text" id="capacidad" name="capacidad" required/>GB</td>';
//        print'</tr>';
//        break;
//    //placa de video
//    case 8:
//        print '<tr><td>Capacidad de memoria</td>';
//        print '<td><input type="text" id="capacidad" name="capacidad" required/>MB</td>';
//        print'</tr>';
//        break;
//    //Placa Red
//    case 9:
//        print '<tr><td>Mac</td>';
//        print '<td><input type="text" id="mac" name="mac" required/></td>';
//        print'</tr>';
//        break;
//    //Placa Audio
//    //lectora    
//    case 11:
//        print '<tr><td>Tipo de Lectora (*)</td>';
//        $query = "select * from tipo_lectora";
//        $resultado = $mysqli->query($query);
//        print '<td><select name="tipo_lectora" id="tipoLectora" required>';
//        print '<option value="" >Seleccione...</option>';
//        while ($row = $resultado->fetch_assoc()) {
//            print "<option value =" . $row['id_tipo_lectora'] . " >";
//            print strtoupper($row['nombre']) . "</option>";
//        }
//        print '</select></td></tr>';
//        $resultado->free();
//        break;
//    //MicroProcesador    
//    case 13:
//        print '<tr><td>Cantidad  De Nucleo</td>';
//        print '<td><input type="text" id="cantNucleo" name="cantNucleo" required/></td>';
//        print'</tr>';
//        print '<tr><td>Velocidad</td>';
//        print '<td><input type="text" id="velocidad" name="velocidad" required/> Ghz</td>';
//        print'</tr>';
//        break;
//    //fuente
//    case 14:
//        print '<tr><td>Potencia</td>';
//        print '<td><input type="text" id="potencia" name="potencia" required/>Watts</td>MB';
//        print'</tr>';
//    default:
//        break;
//}
//
//print '</table>';
print '<button class="submit" name="volver2" id="volver2" >Cancelar</button>';
print '<button class="submit" name="siguiente2" id="siguiente2">Siguiente</button>';
