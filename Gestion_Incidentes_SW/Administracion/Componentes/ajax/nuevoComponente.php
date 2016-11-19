
<?php

require_once '../../../Conexion2.php';
$idTC = filter_input(INPUT_POST, "idTipoComponente");
print '<table><tr>';
print '<td>Marca:</td>';
$query = "select * from marca";
$resultado = $mysqli->query($query);
print '<td><select name="marca" id="marca" required>';
print '<option value="" >Seleccione...</option>';
while ($row = $resultado->fetch_assoc()) {
    print "<option value =\"" . $row['id_marca'] . "\" >";
    print $row['descripcion'] . "</option>";
}
print '</select></td>';
$resultado->free();
print '</tr><tr>';
print '<td>Modelo:</td>';
print '<td><input name="modelo" id="modelo"/><td/>';
print '</tr><tr>';
print '<td>Mes de adquisicion </td>';
print '<td><select name="mes" id="mes" required>';
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
print '</select></td>';
print '</tr><tr>';
print '<td>Año adquisición</td>';
print '<td><input id="anio" name="anio" required/></td>';
print '</tr>';


/* print '<tr><td>Proveedor</td>';
  $query = "select * from proveedor";
  $resultado = $mysqli->query($query);
  print '<td><select name="proveedor" id="proveedor" required>';
  print '<option value="" >Seleccione...</option>';
  while ($row = $resultado->fetch_assoc()) {
  print "<option value =" . $row['id_proveedor'] . " >";
  print $row['nombre'] . "</option>";
  }
  print '</select></td></tr>';
  $resultado->free(); */

/*
 * Aqui se colocan los detalles especificos segun tipo componente
 */



switch ($idTC) {
    case 1:
        //monitor
        print '<tr><td>Tipo de conexion (*)</td>';
        $query = "select * from tipo_conexion";
        $resultado = $mysqli->query($query);
        print '<td><select name="conexion" id="conexion" required>';
        print '<option value="" >Seleccione...</option>';
        while ($row = $resultado->fetch_assoc()) {
            print "<option value =" . $row['nombre'] . " >";
            print strtoupper($row['nombre']) . "</option>";
        }
        print '</select></td></tr>';
        $resultado->free();
        print '<tr><td>Medida (*)</td>';
        print '<td><input type="text" id="tamaño" name="tamaño" required/>Pulgadas</td>';
        print '</tr>';
        break;
    case 2:
        //mouse
        print '<tr><td>Tipo de conexion (*)</td>';
        $query = "select * from tipo_conexion";
        $resultado = $mysqli->query($query);
        print '<td><select name="conexion" id="conexion" required>';
        print '<option value="" >Seleccione...</option>';
        while ($row = $resultado->fetch_assoc()) {
            print "<option value =" . $row['nombre'] . " >";
            print strtoupper($row['nombre']) . "</option>";
        }
        print '</select></td></tr>';
        $resultado->free();
        break;
    //teclado
    case 3:
        print '<tr><td>Tipo de conexion (*)</td>';
        $query = "select * from tipo_conexion";
        $resultado = $mysqli->query($query);
        print '<td><select name="conexion" id="conexion" required>';
        print '<option value="" >Seleccione...</option>';
        while ($row = $resultado->fetch_assoc()) {
            print "<option value =" . $row['nombre'] . " >";
            print strtoupper($row['nombre']) . "</option>";
        }
        print '</select></td></tr>';
        $resultado->free();
        break;
    //Memoria RAM
    case 5:
        print '<tr><td>Tipo de memoria (*)</td>';
        $query = "select * from tipo_memoria";
        $resultado = $mysqli->query($query);
        print '<td><select name="tipo_memoria" id="tipo_memoria" required>';
        print '<option value="" >Seleccione...</option>';
        while ($row = $resultado->fetch_assoc()) {
            print "<option value =" . $row['nombre'] . " >";
            print strtoupper($row['nombre']) . "</option>";
        }
        print '</select></td></tr>';
        $resultado->free();
        print '<tr><td>Capacidad</td>';
        print '<td><input type="text" id="capacidad" name="capacidad" required/>GB</td>';
        print '</tr>';
        print '<tr><td>Frecuencia</td>';
        print '<td><input type="text" id="frecuencia" name="frecuencia" required/>Mhz</td>';
        print '</tr>';
        break;
    //Disco Duro
    case 6:
        print '<tr><td>Tipo de conexion (*)</td>';
        $query = "select * from tipo_conexion";
        $resultado = $mysqli->query($query);
        print '<td><select name="conexion" id="conexion" required>';
        print '<option value="" >Seleccione...</option>';
        while ($row = $resultado->fetch_assoc()) {
            print "<option value =" . $row['nombre'] . " >";
            print strtoupper($row['nombre']) . "</option>";
        }
        print '</select></td></tr>';
        $resultado->free();
        print '<tr><td>Velocidad de transferencia(*)</td>';
        print '<td><input type="text" id="velTransferencia" name="velTransferencia" required/>Rpm</td>';
        print'</tr>';
        print '<tr><td>Capacidad</td>';
        print '<td><input type="text" id="capacidad" name="capacidad" required/>GB</td>';
        print'</tr>';
        break;
    //placa de video
    case 8:
        print '<tr><td>Capacidad de memoria</td>';
        print '<td><input type="text" id="capacidad" name="capacidad" required/>MB</td>';
        print'</tr>';
        break;
    //Placa Red
    case 9:
        print '<tr><td>Mac</td>';
        print '<td><input type="text" id="mac" name="mac" required/></td>';
        print'</tr>';
        break;
    //Placa Audio
    //lectora    
    case 11:
        print '<tr><td>Tipo de Lectora (*)</td>';
        $query = "select * from tipo_lectora";
        $resultado = $mysqli->query($query);
        print '<td><select name="tipo_lectora" id="tipoLectora" required>';
        print '<option value="" >Seleccione...</option>';
        while ($row = $resultado->fetch_assoc()) {
            print "<option value =" . $row['id_tipo_lectora'] . " >";
            print strtoupper($row['nombre']) . "</option>";
        }
        print '</select></td></tr>';
        $resultado->free();
        break;
    //MicroProcesador    
    case 13:
        print '<tr><td>Cantidad  De Nucleo</td>';
        print '<td><input type="text" id="cantNucleo" name="cantNucleo" required/></td>';
        print'</tr>';
        print '<tr><td>Velocidad</td>';
        print '<td><input type="text" id="velocidad" name="velocidad" required/> Ghz</td>';
        print'</tr>';
        break;
    //fuente
    case 14:
        print '<tr><td>Potencia</td>';
        print '<td><input type="text" id="potencia" name="potencia" required/>Watts</td>MB';
        print'</tr>';
    default:
        break;
}

print '</table>';
print '<button class="submit" name="volver2" id="volver2" onclick="location.assign(\'../PrincipalAdministracion.php\');">Cancelar</button>';
print '<button class="submit" name="siguiente2" id="siguiente2">Siguiente</button>';