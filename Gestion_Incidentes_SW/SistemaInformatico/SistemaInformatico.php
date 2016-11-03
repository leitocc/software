<?php

session_start();
require_once '../Conexion2.php';
try {
    $modo = filter_input(INPUT_POST, "modo");
    if (isset($modo) && $modo == "del") {
        $si = filter_input(INPUT_POST, "si");
        $consulta = $mysqli->query("UPDATE sistema_informatico SET baja = 1 "
                . "WHERE id_sistema_informatico=" . $si);
        if ($consulta) {
            $msj = 3;
        }else{
            $msj = 2;
        }
    } else {
        if ($modo == "modi") {
            $siOrigen = filter_input(INPUT_POST, "si");
            $siDestino = filter_input(INPUT_POST, "siDestino");
            if ($siOrigen !== '' && $siDestino !== '') {
                $queryModificacion = "UPDATE sistema_informatico SET id_sistema_informatico= " . $siDestino .
                        " where id_sistema_informatico = " . $siOrigen;
                $update_row = $mysqli->query($queryModificacion);
                if ($update_row) {
                    $msj = 3;
                }else{
                    $msj = 2;
                }
            } else {
                $msj = 2;
            }
        }else {
//            echo "Entro en alta";
//            echo "<br/>";
            $si = filter_input(INPUT_POST, "si");
            $sala = filter_input(INPUT_POST, "sala");
            $consultaSI = "SELECT id_sistema_informatico FROM sistema_informatico SI "
                    . "WHERE id_sala=" . $sala . " AND id_sistema_informatico = " . $si;
//            echo $consultaSI;
            $queryCorroborar = $mysqli->query($consultaSI);
            if ($queryCorroborar && $queryCorroborar->num_rows > 0) {
                //Dar de alta si ya existia el SI
                $darAlta = $mysqli->query("UPDATE sistema_informatico SET baja = 0 "
                        . "WHERE id_sistema_informatico = " . $si);
                if($darAlta && $mysqli->affected_rows > 0){
                    $msj = 3;
                }else{
                    $msj = 2;
                }
            } else {
                $insertarSI = "INSERT into sistema_informatico (id_sistema_informatico, "
                        . "id_sala,baja) values (" . $si . " , " . $sala . ", 0)";
//                echo $insertarSI;
                $insertar = $mysqli->query($insertarSI);
                if($insertar && $mysqli->affected_rows > 0){
                    $msj = 1;
                }else{
                    $msj = 2;
                }
            }
        }
    }
} catch (Exception $ex) {
    $msj = 2;
}
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/SistemaInformatico/PrincipalSistemaInformatico.php?msj=' . $msj . '');
//echo "<br/>";
//echo "mensaje: " . $msj;

