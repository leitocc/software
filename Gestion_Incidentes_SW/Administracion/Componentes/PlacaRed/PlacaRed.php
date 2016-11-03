<?php

session_start();
try {
    require_once '../../../Conexion.php';
    if ($_REQUEST['modo'] == "del") {
        $consulta = mysql_query("SELECT id_componente AS id FROM componente where id_tipo_componente = 9 and baja=0 and id_sistema_informatico=" . $_SESSION['si']);
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
            $consulta = mysql_query("Insert into componente (id_componente,id_tipo_componente, "
                    . "descripcion, id_marca,anio_adquisicion, mes_adquisicion,id_proveedor,"
                    . "nro_serie,id_sistema_informatico,baja,fecha_instalacion,fecha_baja,id_subcomponente) "
                    . "values (" . $id . ", 9, '" . $modelo . "'," . $marca . "," . $año . "," . $mes . ",null," . $nroSerie . "," . $Sistema . ",0,sysdate(),null," . $idSubcomponente . ")");

            #Detalle MAC
            if ($_POST['mac'] === null) {
                
            } else {
                $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
                if ($row = mysql_fetch_row($consulta)) {
                    $idDetalle = trim($row[0]) + 1;
                }
                $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, valor_alfanumerico,id_descipcion) values(" . $idDetalle . "," . $id . ",'" . $_POST['mac'] . "', 10)");
            }

            #Detalle Vel

            if ($_POST['velocidad'] === '') {
                
            } else {
                $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
                if ($row = mysql_fetch_row($consulta)) {
                    $idDetalle = trim($row[0]) + 1;
                }
                $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, valor,id_descipcion, id_unidad_medida) values(" . $idDetalle . "," . $id . ",'" . $_POST['velocidad'] . "', 1, 5)");
            }
            #Detalle de subcomponente
            $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
            if ($row = mysql_fetch_row($consulta)) {
                $idDetalle = trim($row[0]) + 1;
            }
            $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, id_subcomponente) values(" . $idDetalle . ", " . $_POST['SI'] . "," . $id . " )");
            $mensaje = "Se grabo correctamente la placa de red ";
        }if ($_REQUEST['modo'] == "mod") {
            $consulta = mysql_query("SELECT id_componente AS id FROM componente where id_tipo_componente = 9 and id_sistema_informatico=" . $_SESSION['si']);
            while ($row = mysql_fetch_array($consulta)) {
                $idComponente = $row['id'];
            }

            $consulta = mysql_query("UPDATE componente SET descripcion='" . $modelo . "' ,id_marca=" . $marca . " ,anio_adquisicion=" . $año . " ,mes_adquisicion=" . $mes . ",nro_serie=" . $nroSerie . " WHERE id_componente =" . $idComponente);

            if ($_POST['velocidad'] === '') {
                
            } else {
                $vel = $_POST['velocidad'];
                $consulta = mysql_query("Update detalle_componente set valor=" . $vel . " where id_componente=" . $idComponente . " and id_descipcion=1");
            }

            if ($_POST['mac'] === null) {
                
            } else {
                $mac = $_POST['mac'];
                $consulta = mysql_query("Update detalle_componente set valor_alfanumerico='" . $mac . "' where id_componente=" . $idComponente . " and id_descipcion=10");
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