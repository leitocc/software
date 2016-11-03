
<?php
$idTC = filter_input(INPUT_POST, "idTipoComponente");
$si = filter_input(INPUT_POST, "si");
require_once '../../Conexion2.php';
$query = "SELECT I.id_incidente, I.fecha, C.nombre, count(DI.id_detalle_intervencion) AS 'intervenciones', SUM(TIME_FORMAT(DI.hora_fin - DI.hora_inicio, '%h:%i:%s')) AS 'horas', E.nombre_estado 
    FROM detalle_intervencion DI 
    INNER JOIN incidente I ON DI.id_incidente = I.id_incidente 
    INNER JOIN componentexdetalle_intervencion CXDI ON DI.id_detalle_intervencion = CXDI.id_detalle_intervencion 
    INNER JOIN causa_incidente C ON I.id_causa_incidente = C.id_tipo_incidente 
    INNER JOIN estado E ON I.id_estado = E.id_estado 
    INNER JOIN componente CO ON CXDI.id_componente = CO.id_componente 
    WHERE I.id_sistema_informatico_afectado = " . $si .
        " AND CO.id_tipo_componente = " . $idTC .
        " GROUP BY I.id_incidente, I.fecha, C.nombre, E.nombre_estado";
$resultado = $mysqli->query($query);
if (!$resultado)
    die("Fallo el comando:" . mysql_error());
elseif ($mysqli->affected_rows != 0) {
    ?>
    <table class = "listado2">
        <thead>
            <tr>
                <th>
                    Nro. Incidente
                </th>
                <th>
                    Fecha y Hora
                </th>
                <th>
                    Indicio<br/>de origen
                </th>
                <th>
                    Cantidad<br/>Intervenciones
                </th>
                <th>
                    Tiempo total intervencion<br/>componente (Hs.)
                </th>
                <th>
                    Estado<br/>Incidente
                </th>
                <th>
                    Ver<br/>detalles
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $resultado->fetch_assoc()) {
                print '<tr>';
                print '<td>' . $row['id_incidente'] . '</td>';
                print '<td>' . $row['fecha'] . '</td>';
                print '<td>' . $row['nombre'] . '</td>';
                print '<td>' . $row['intervenciones'] . '</td>';
                print '<td>' . $row['horas'] . '</td>';
                print '<td>' . $row['nombre_estado'] . '</td>';
                print '<td><a href = "../Incidentes/DetalleIncidente.php?id=' . $row['id_incidente'] . '">Ir...</a></td>';
                print '</tr>';
            }
            ?>
        </tbody>
    </table>
    <?php
    print '<h4>Total: ' . $mysqli->affected_rows . ' registros</h4>';
} else {
    print '<h5>No hay registros que afecten el componente</h5>';
}
$resultado->free();
