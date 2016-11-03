<?php

session_start();
try {
    require_once '../../Conexion2.php';
    $msj = "";
    $modo = filter_input(INPUT_POST, "modo");
    $nombre = filter_input(INPUT_POST, "nombre");
    if ($modo === "ins") {
//        $consultamarca = "SELECT MAX(id_marca) AS id FROM marca";
//        $resultadoMaxId = $mysqli->query($consultamarca);
//        if ($row = $consulta->fetch_assoc()) {
//            $idMarca['id'] = $row["id_marca"];
//        } else {
//            $idMarca['id'] = 0;
//        }
//        $idMarca['id'] ++;
        $queryMarca = "INSERT INTO marca (`descripcion`) VALUES ('" . $nombre . "');";
        $consultaMarca = $mysqli->query($queryMarca);
        $msj = 1;
    } elseif ($modo === "mod") {
        $idMarca = filter_input(INPUT_POST, "idMarca");
        $queryActualizar = "UPDATE marca SET descripcion = '" . $nombre . "' where id_marca = " . $idMarca . ";";
        $consulta = $mysqli->query($queryActualizar);
        $msj = 3;
    } else {
        $msj = 2;
    }
} catch (mysqli_sql_exception $myE) {
    $msj = 2;
} catch (Exception $e) {
    $msj = 2;
}
echo $msj;
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/Administracion/PrincipalAdministracion.php?msj=' . $msj .'');
