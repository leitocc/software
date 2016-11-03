<?php
session_start();
//$componentes = $_SESSION["componentes"];
echo "entre<br/>";
$quitar = filter_input(INPUT_POST, "quitar");
print $quitar;
if (empty($quitar) && !is_numeric($quitar)) {
    echo 'agrega';
    $tipoComponente = filter_input(INPUT_POST, "tipoComponente");
    $accion = filter_input(INPUT_POST, "accion");

    //$componentes = $_SESSION["componentes"];
    print '<br/>';
    $_SESSION["componentes"][] = array("tipo" => $tipoComponente, "accion" => $accion);
    //print_r($_SESSION["componentes"]);
} else {
    unset($_SESSION["componentes"][$quitar]);
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
$index = 0;
foreach ($_SESSION["componentes"] as $comp) {
    ?>
            <tr>
                <td><?php echo $comp["tipo"] ?></td>
                <td><?php echo $comp["accion"] ?></td>
                <td>
                    <a onclick="javascript:quitarComponente(<?php echo $index ?>);">Quitar</a>
                </td>
            </tr>
    <?php $index++;
}/* ?>
  <tr>
  <td><?php echo $tipoComponente ?></td>
  <td><?php echo $accion ?></td>
  <td><a href="tablaComponentesAfectados.php?quitar=<?php echo $index ?>">Quitar</a></td>
  </tr> */ ?>
    </tbody>
</table>