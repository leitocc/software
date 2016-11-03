
<?php
require_once '../../formatoFecha.class.php';
$estado = $_REQUEST['estado'];
$sala = $_REQUEST['sala'];
$si = $_REQUEST['si'];
$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];

if ($hasta != '' && $hasta != "Seleccione...") {
    $hasta = formatoFecha::convertirAFechaSolaBD($hasta);
    /* echo $hasta."<br/>";
      $hasta = date('Y-m-d');
      $hasta = strtotime($hasta);
      echo $hasta."<br/>";
      $hasta = strtotime ( '+1 day' , $hasta ) ;
      echo $hasta."<br/>";
      $hasta = date('Y-m-d');
      //$hasta = date_create_from_format('d/m/Y', 'H:i:s', $_REQUEST['hasta']);
      echo $hasta."<br/>"; */

    //date_add($hasta, date_interval_create_from_date_string('1 day'));
    //date_add($hasta, date_interval_create_from_date_string('1 month'));
    //ñecho print_r($hasta)."<br/>";
}
/* echo "estado: ".$estado."<br/>";
  echo "desde: ".$desde."<br/>";
  echo "hasta: ".$hasta."<br/>"; */
//if($estado != NULL && $desde != NULL && $hasta != NULL){
require_once '../../Conexion.php';
//echo "entro: 1<br/>";
$buscarIncidentes = "SELECT I.id_incidente AS id, I.fecha, I.id_sistema_informatico_afectado AS si,
                        S.nombre AS sala, C.nombre AS causa, E.nombre_estado AS estado
                        FROM incidente I INNER JOIN sala S ON I.id_sala = S.id_sala 
                        INNER JOIN causa_incidente C ON I.id_causa_incidente = C.id_tipo_incidente
                        INNER JOIN estado E ON I.id_estado = E.id_estado ";
//echo "bsq: ".$buscarIncidentes."<br/>";

if ($estado != '' && $estado != "Todos") {
    //echo "entro: 2<br/>";
    $buscarIncidentes = $buscarIncidentes . "AND E.id_estado = \"" . $estado . "\" ";
}
if ($sala !== '') {
    $buscarIncidentes = $buscarIncidentes . "AND S.id_sala = \"" . $sala . "\" ";
    if ($si !== '') {
        $buscarIncidentes = $buscarIncidentes . "AND I.id_sistema_informatico_afectado = \"" . $si . "\" ";
    }
}

if ($desde != '' && $desde != "Seleccione...") {
    //echo "entro: 3<br/>";
    $desde = formatoFecha::convertirAFechaSolaBD($desde);
    $buscarIncidentes = $buscarIncidentes . "AND I.fecha > \"" . $desde . "\" ";
}
if (isset($hasta) && $hasta != '' && $hasta != "Seleccione...") {
    echo "entro: 4<br/>";

    //$buscarIncidentes = $buscarIncidentes."AND I.fecha <= \"".date_format($hasta, 'Y-m-d')."\" ";
    $buscarIncidentes = $buscarIncidentes . "AND I.fecha <= \"" . $hasta . " 23:59:59\" ";
}
$buscarIncidentes = $buscarIncidentes . "ORDER BY I.id_incidente ASC";
//echo "query: ".$buscarIncidentes."<br/>";

$query1 = mysql_query($buscarIncidentes);

if (mysql_errno() == 0 && mysql_num_rows($query1) > 0) {
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
            </tr>
        </thead>
        <tbody>

            <?php
            while ($row = mysql_fetch_array($query1)) {
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
                        <?php echo $row['si'] ?>
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
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
} else {
    ?>
    <h4>No hay registros de incidentes</h4>
    <?php
}