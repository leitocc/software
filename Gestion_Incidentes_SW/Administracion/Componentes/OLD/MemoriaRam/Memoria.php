<?php

session_start();
try {
    require_once '../../../Conexion.php';
    if ($_REQUEST['modo'] == "del") {
        $consulta = mysql_query("SELECT id_componente AS id FROM componente where id_tipo_componente = 5 and baja=0 and id_sistema_informatico=" . $_SESSION['si']);
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

        if ($_POST['fre'] === '') {
            $frecuencia = null;
        } else {
            $frecuencia = $_POST['fre'];
        }
        if ($_POST['capac'] === '') {
            $capacidad = null;
        } else {
            $capacidad = $_POST['capac'];
        }

        if ($_POST['tipo'] === 'Ninguno') {
            $tipo = null;
        } else {
            $tipo = $_POST['tipo'];
        }

        $mensaje = "Se grabo correctamente";

        if ($_REQUEST['modo'] == "ins") {
            $consulta = mysql_query("SELECT MAX(id_componente) AS id FROM componente");
            if ($row = mysql_fetch_row($consulta)) {
                $id = trim($row[0]) + 1;
            }
            $consulta = mysql_query("Insert into componente (id_componente,id_tipo_componente, "
                    . "descripcion, id_marca,anio_adquisicion, mes_adquisicion,id_proveedor,"
                    . "nro_serie,id_sistema_informatico,baja,fecha_instalacion,fecha_baja,id_subcomponente) values (" . $id . ", 5, '" . $modelo . "'," . $marca . "," . $año . "," . $mes . ",null," . $nroSerie . "," . $Sistema . ",0,sysdate(),null," . $idSubcomponente . ")");

            #Detalle de velocidad

            if ($_POST['fre'] === '') {
                
            } else {
                $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
                if ($row = mysql_fetch_row($consulta)) {
                    $idDetalle = trim($row[0]) + 1;
                }
                $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, valor,id_descipcion, id_unidad_medida) values(" . $idDetalle . "," . $id . ",'" . $frecuencia . "', 1, 1)");
            }

            #Detalle de capacidad

            if ($_POST['capac'] === '') {
                
            } else {
                $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
                if ($row = mysql_fetch_row($consulta)) {
                    $idDetalle = trim($row[0]) + 1;
                }
                $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, valor,id_descipcion,id_unidad_medida) values(" . $idDetalle . "," . $id . ",'" . $capacidad . "', 2,6)");
            }
            # Detalle de tipo de memoria
            if ($_POST['tipo'] === 'Ninguno') {
                
            } else {
                $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
                if ($row = mysql_fetch_row($consulta)) {
                    $idDetalle = trim($row[0]) + 1;
                }
                $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, valor_alfanumerico,id_descipcion) values(" . $idDetalle . "," . $id . ",'" . $tipo . "', 4)");
            }

            #Detalle de subcomponente
            $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
            if ($row = mysql_fetch_row($consulta)) {
                $idDetalle = trim($row[0]) + 1;
            }
            $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, id_subcomponente) values(" . $idDetalle . ", " . $_POST['SI'] . "," . $id . " )");
            $mensaje = "Se grabo correctamente la memoria";
        }if ($_REQUEST['modo'] == "mod") {
            $consulta = mysql_query("SELECT id_componente AS id FROM componente where id_tipo_componente = 5 and id_sistema_informatico=" . $_SESSION['si']);
            while ($row = mysql_fetch_array($consulta)) {
                $idComponente = $row['id'];
            }

            $consulta = mysql_query("UPDATE componente SET descripcion='" . $modelo . "' ,id_marca=" . $marca . " ,anio_adquisicion=" . $año . " ,mes_adquisicion=" . $mes . ",nro_serie=" . $nroSerie . " WHERE id_componente =" . $idComponente);

            if ($_POST['capac'] === '') {
                
            } else {
                $capac = $_POST['capac'];
                $consulta = mysql_query("Update detalle_componente set valor=" . $capac . " where id_componente=" . $idComponente . " and id_descipcion=2");
            }

            if ($_POST['fre'] === '') {
                
            } else {
                $frec = $_POST['fre'];
                $consulta = mysql_query("Update detalle_componente set valor=" . $frec . " where id_componente=" . $idComponente . " and id_descipcion=1");
            }

            if ($_POST['tipo'] === 'Ninguno') {
                
            } else {
                $tipo = $_POST['tipo'];
                $consulta = mysql_query("Update detalle_componente set valor_alfanumerico='" . $tipo . "' where id_componente=" . $idComponente . " and id_descipcion=4");
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