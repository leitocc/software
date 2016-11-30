<?php

require_once '../../Conexion2.php';
require_once '../../DetalleComponente.class.php';
session_start();
$vectorComponente = $_SESSION['Componente'];
$vectorDetalles = $_SESSION['Detalles'];

$vectorMaquinas = $_POST["SI"];
//
//print 'vector maquinas: ';
//print_r($vectorMaquinas);
//print '<br/>';
//print 'vector componentes: ';
//print_r($vectorComponente);
//print '<br/>';
//print '<br/>';
//print 'vector detalles: ';
//print_r($vectorDetalles);
//print '<br/>';
//print '<br/>';

//primero se debe grabar el Componente por maquina
//luego grababar los detalles de cada componente
try {
    $mysqli->autocommit(FALSE);
    foreach ($vectorMaquinas as $maquina) {
        $permiteVarios = array(5, 6);
        if (!in_array($row['id_componente'], $permiteVarios)) {
            $queryBuscar = "SELECT id_componente 
            FROM componente
            WHERE id_sistema_informatico = " . $maquina .
                    " AND id_tipo_componente = " . $vectorComponente["idTipoComponente"] .
                    " AND baja = 0";
//            echo $queryBuscar . '<br/>';
//            echo '<br/>';
            $resultado = $mysqli->query($queryBuscar);
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    $update = "UPDATE componente SET 
                        baja = 1,
                        fecha_baja = " . date("Y-m-d") .
                            " WHERE id_componente = " . $row['id_componente'];
//                    echo $update . '<br/>';
//                    echo '<br/>';
                    if (!$mysqli->query($update)) {
                        throw new Exception ();
                    }
                }
            }
        }

        $query10 = "INSERT INTO componente"
                . "(id_tipo_componente,"
                . "id_marca,anio_adquisicion,"
                . "mes_adquisicion,"
                . "id_proveedor,"
                . "id_sistema_informatico,"
                . "baja) values("
                . $vectorComponente["idTipoComponente"] . ", "
                . $vectorComponente["marca"] . ", "
                . $vectorComponente["anio"] . ", "
                . $vectorComponente["mes"] . ","
                . "null, "
                . $maquina . ","
                . " 0)";
//        echo $query10 . '<br/>';
//        echo '<br/>';
        if ($mysqli->query($query10)) {
            $idComponente = $mysqli->insert_id;
//            echo "nuevo maquina insertada " . $mysqli->insert_id . "<br/>";
//            echo "idCo: " . $idComponente . "<br/>";
            if ($vectorDetalles != NULL) {
                foreach ($vectorDetalles as $detalle) {
                    $valor = "null";
                    $valorAlfa = "null";
                    if ($detalle->getValor() != "") {
                        $valor = $detalle->getValor();
                    }
                    if ($detalle->getValor_alfanumerico() != "") {
                        $valorAlfa = $detalle->getValor_alfanumerico();
                    }
                    $query11 = "INSERT INTO detalle_componente"
                            . "(id_componente,"
                            . "id_descipcion,"
                            . "valor,"
                            . "valor_alfanumerico,"
                            . "id_unidad_medida) values ("
                            . $idComponente . ", "
                            . $detalle->getId_descripcion() . ","
                            . $valor . ", "
                            . $valorAlfa . ", "
                            . $detalle->getId_unidad_medida() . ")";
//                    echo $query11 . "</br>";
                    echo '<br/>';
                    if (!$mysqli->query($query11)) {
                        throw new Exception ();
                    }
                }
            }
            $mysqli->commit();
            $msj = 1;
        } else {
            throw new Exception ();
        }
    }
} catch (Exception $ex) {
    $mysqli->rollback();
    $msj = 2;
}
//echo 'msj= ' . $msj;
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/Administracion/PrincipalAdministracion.php?msj=' . $msj . '');
//header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/IncidentesHW/InicioIncidentes.php?msj=' . $msj . '');
