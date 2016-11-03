<?php

session_start();
try {
    require_once '../../../Conexion.php';
    if ($_REQUEST['modo'] == "del") {
        $consulta = mysql_query("SELECT id_componente AS id FROM componente where id_tipo_componente = 8 and baja=0 and id_sistema_informatico=" . $_SESSION['si']);
        while ($row = mysql_fetch_array($consulta)) {
            $idComponente = $row['id'];
        }

        $consulta = mysql_query("UPDATE componente SET baja=1, fecha_baja=Sysdate() WHERE id_componente=" . $idComponente);
        $mensaje = "Se borro correctamente el componente";
    } else {
        if ($_POST['SI'] === '') {
            $Sistema = null;
        } else {
            $Sistema = $_POST['SI'];
        }
        if (!isset($_POST['idSub'])) {
            $idSubcomponente = null;
        } else {
            $idSubcomponente = $_POST['idSub'];
        }
        if ($_POST['modelo'] === '') {
            $modelo = null;
        } else {
            $modelo = $_POST['modelo'];
        }

        if ($_POST['nroSerie'] === '') {
            $nroSerie = 'null';
        } else {
            $nroSerie = "'" . $_POST['nroSerie'] . "'";
        }

        if ($_POST['marca'] === 'Ninguno') {
            $marca = null;
        } else {
            $marca = $_POST['marca'];
        }

        if ($_POST['mes'] === 'Ninguno') {
            $mes = null;
        } else {
            $mes = $_POST['mes'];
        }

        if ($_POST['año'] === '') {
            $año = null;
        } else {
            $año = $_POST['año'];
        }

        if ($_POST['proveedor'] === 'Ninguno') {
            $proveedor = null;
        } else {
            $proveedor = $_POST['proveedor'];
        }



        $mensaje = "Se grabo correctamente";


        if ($_REQUEST['modo'] == "ins") {
            $consulta = mysql_query("SELECT MAX(id_componente) AS id FROM componente");
            if ($row = mysql_fetch_row($consulta)) {
                $id = trim($row[0]) + 1;
            }
            $queryInsert = "Insert into componente (id_componente,id_tipo_componente, "
                    . "descripcion, id_marca,anio_adquisicion, mes_adquisicion,id_proveedor,"
                    . "nro_serie,id_sistema_informatico,baja,fecha_instalacion,fecha_baja,id_subcomponente) values (" . $id . ", 8, '" . $modelo . "'," . $marca . "," . $año . "," . $mes . ",null," . $nroSerie . "," . $Sistema . ",baja,sysdate(),null," . $idSubcomponente . ")";

            $consulta = mysql_query($queryInsert);
            echo $queryInsert . "<br/>";
            #Detalle de memoria 

            if ($_POST['memoria'] === '') {
                
            } else {
                $memoria = $_POST['memoria'];
                $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
                if ($row = mysql_fetch_row($consulta)) {
                    $idDetalle = trim($row[0]) + 1;
                }
                $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, valor,id_descipcion, id_unidad_medida) values(" . $idDetalle . "," . $id . ",'" . $memoria . "', 2, 5)");
            }

            #Detalle de subcomponente
            $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
            if ($row = mysql_fetch_row($consulta)) {
                $idDetalle = trim($row[0]) + 1;
            }
            $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, id_subcomponente) values(" . $idDetalle . ", " . $_POST['SI'] . "," . $id . " )");
            $mensaje = "Se grabo correctamente la placa de video ";
        }if ($_REQUEST['modo'] == "mod") {
            $consulta = mysql_query("SELECT id_componente AS id FROM componente where id_tipo_componente = 8 and id_sistema_informatico=" . $_SESSION['si']);
            while ($row = mysql_fetch_array($consulta)) {
                $idComponente = $row['id'];
            }

            $consulta = mysql_query("UPDATE componente SET descripcion='" . $modelo . "' ,id_marca=" . $marca . " ,anio_adquisicion=" . $año . " ,mes_adquisicion=" . $mes . ",nro_serie=" . $nroSerie . " WHERE id_componente =" . $idComponente);

            if ($_POST['memoria'] === '') {
                
            } else {
                $memoria = $_POST['memoria'];
                $consulta = mysql_query("Update detalle_componente set valor=" . $memoria . " where id_componente=" . $idComponente . " and id_descipcion=2");
                echo "Update detalle_componente set valor=" . $memoria . " where id_componente=" . $idComponente . " and id_descipcion=2";
            }
            $mensaje = "Se actualizo correctamente el componente";
        }
    }
} catch (Exception $e) {
    $mensaje = "Error al grabar en la BD";
}
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/Administracion/Componentes/CPU/PaginaCPUSegunda.php');
$_SESSION['mensaje'] = $mensaje;
?>