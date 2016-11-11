<?php
session_start();
//$componentes = $_SESSION["componentes"];
$quitar = filter_input(INPUT_POST, "quitar");
//print "index a quitar: ". $quitar;
//print '<br/>';
if (empty($quitar) && !is_numeric($quitar)) {
    //echo 'agrega';
    $idComponente = filter_input(INPUT_POST, "idComponente");
    $idAccion = filter_input(INPUT_POST, "idAccion");
    if($idComponente != "" && $idAccion != ""){
        $combo = filter_input(INPUT_POST, "combo");
        $accion = filter_input(INPUT_POST, "accion");
        //$componentes = $_SESSION["componentes"];
        //print '<br/>';
        $existe = false;
        foreach ($_SESSION["componentes"] as $comp){
            if($comp['idComponente'] == $idComponente){
                $existe = true;
            }
        }
        if(!$existe){
            $_SESSION["componentes"][] = array("idComponente" => $idComponente, "idAccion" => $idAccion,
                "combo" => $combo, "accion" => $accion, "index" => count($_SESSION["componentes"]));
            //print_r($_SESSION["componentes"]);
            //print '<br/>';
        }else{
            echo "<p>Ya se agrego dicho componente y acción!!</p>";
        }
    }else{
        echo "<p>Seleccione primero componente y acción</p>";
    }
} else {
    unset($_SESSION["componentes"][$quitar]);
    //print_r($_SESSION["componentes"]);
    //print '<br/>';
}
?>

<table class="listado2">
    <thead>
        <tr>
            <th>Tipo de componente</th>
            <th>Acci&oacute;n correctiva</th>
            <th>Quitar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($_SESSION["componentes"] as $comp) {
            echo '<tr>';
            echo '<td>' . $comp["combo"] . '</td>';
            echo '<td>' . $comp["accion"] . '</td>';
            echo '<td>';
            echo '<a onclick="javascript:quitarComponente(' . $comp["index"] . ');">Quitar</a>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php /*  <tr>
  <td><?php echo $tipoComponente ?></td>
  <td><?php echo $accion ?></td>
  <td><a href="tablaComponentesAfectados.php?quitar=<?php echo $index ?>">Quitar</a></td>
  </tr> */

    
