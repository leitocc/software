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
    $idIndicio = filter_input(INPUT_POST, "idIndicio");
    if($idComponente != "" && $idAccion != "" && $idIndicio != ""){
        $combo = filter_input(INPUT_POST, "combo");
        $accion = filter_input(INPUT_POST, "accion");
        $indicio = filter_input(INPUT_POST, "indicio");
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
                "combo" => $combo, "accion" => $accion, "index" => count($_SESSION["componentes"]),
                "idIndicio" => $idIndicio, "indicio" => $indicio);
            //print_r($_SESSION["componentes"]);
            //print '<br/>';
        }else{
            echo "<p>Ya se agrego dicho componente!!</p>";
        }
    }else{
        echo "<p>Debe seleccionar un conjunto de componente, causa y acción</p>";
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
            <th>Componente</th>
            <th>Indicio/Causa</th>
            <th>Acci&oacute;n correctiva</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($_SESSION["componentes"] as $comp) {
            echo '<tr>';
            echo '<td>' . $comp["combo"] . '</td>';
            echo '<td>' . $comp["indicio"] . '</td>';
            echo '<td>' . $comp["accion"] . '</td>';
            echo '<td>';
            echo '<a onclick="javascript:quitarComponente(' . $comp["index"] . ');">Quitar</a>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>