<?php
require_once '../../formatoFecha.class.php';
$estado = $_REQUEST['estado'];
$prioridad = $_REQUEST['prioridad'];
$sala = $_REQUEST['sala'];
$si = $_REQUEST['si'];
$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];


require_once '../../Conexion2.php';
$buscarIncidentes = "SELECT I.idIncidente AS id, I.fecha, I.id_sistema_informatico AS SI,S.nombre AS sala, CS.nombre AS causa, E.nombre_estado AS estado, P.nombre as Prioridad
                         FROM incidente_software I INNER JOIN sistema_informatico SI on I.id_sistema_informatico=SI.id_sistema_informatico INNER JOIN sala S on SI.id_sala=S.id_Sala 
                         INNER JOIN causa_incidente_software CS ON I.id_causa_incidente = CS.idCausa INNER JOIN estado E ON I.id_estado = E.id_estado INNER JOIN prioridad P on I.id_prioridad=P.idPrioridad ";

if ($estado != '' && $estado != "Todos") {
    $buscarIncidentes = $buscarIncidentes . "AND E.id_estado = \"" . $estado . "\" ";
}
if ($prioridad != '' && $prioridad != "Todos") {
    $buscarIncidentes = $buscarIncidentes . "AND P.idPrioridad = \"" . $prioridad . "\" ";
}
if ($sala !== '') {
    $buscarIncidentes = $buscarIncidentes . "AND S.id_sala = \"" . $sala . "\" ";
    if ($si !== '') {
        $buscarIncidentes = $buscarIncidentes . "AND I.id_sistema_informatico = \"" . $si . "\" ";
    }
}
if ($desde != '' && $desde != "Seleccione...") {
    $desde = formatoFecha::convertirAFechaSolaBD($desde);
    $buscarIncidentes = $buscarIncidentes . "AND I.fecha > \"" . $desde . "\" ";
}
if (isset($hasta) && $hasta != '' && $hasta != "Seleccione...") {
    $hasta = formatoFecha::convertirAFechaSolaBD($hasta);
    //$buscarIncidentes = $buscarIncidentes."AND I.fecha <= \"".date_format($hasta, 'Y-m-d')."\" ";
    $buscarIncidentes = $buscarIncidentes . "AND I.fecha <= \"" . $hasta . " 23:59:59\" ";
}
$buscarIncidentes = $buscarIncidentes . " ORDER BY I.idIncidente ASC";
$resultadoBuscarIncidentes = $mysqli->query($buscarIncidentes);
//echo $buscarIncidentes;
if (($resultadoBuscarIncidentes->num_rows > 0)) {
    ?>
    <table class="listado">
        <caption>Incidentes</caption>
        <thead>
            <tr>
                <th>
                    Nro.
                </th>
                <th>
                    Fecha
                </th>
                <th>
                    Hora
                </th>
                <th>
                    Equipo
                </th>
                <th>
                    Sala
                </th>
                <th>
                    Causa
                </th>
                <th>
                    Estado
                </th>
                <th>
                    Prioridad
                </th>
            </tr>
        </thead>
        <tbody>

            <?php
            while ($row = $resultadoBuscarIncidentes->fetch_assoc()) {
                ?>
                <tr onclick="irDetalle(<?php echo $row['id'] ?>)">
                    <td>
                        <?php /* <a href="DetalleIncidente.php?id=<?php echo $row['id']?>"><?php echo $row['id']?></a> */ ?>
                        <?php echo $row['id'] ?>
                    </td>
                    <td>
                        <?php echo formatoFecha::convertirAFechaSolaWeb(substr($row['fecha'], 0, 10)) ?>
                    </td>
                    <td>
                        <?php echo substr($row['fecha'], 11, 5) ?>
                    </td>
                    <td>
                        <?php echo $row['SI'] ?>
                    </td>
                    <td>
                        <?php echo $row['sala'] ?>
                    </td>
                    <td>
                        <?php echo $row['causa'] ?>
                    </td>
                    <td>
                        <?php echo $row['estado'] ?>
                    </td>
                    <td>
                        <?php echo $row['Prioridad'] ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
} else {
    echo '<h4>No hay registros de incidentes</h4>';
}

    