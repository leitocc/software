<?php

session_start();
try {
    require_once '../../../Conexion.php';
    if ($_REQUEST['modo'] == "del") {
        $consulta = mysql_query("SELECT id_componente AS id FROM componente where id_tipo_componente = 13 and baja=0 and id_sistema_informatico=" . $_SESSION['si']);
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

        if ($_POST['nucleo'] === '') {
            $nucleos = null;
        } else {
            $nucleos = $_POST['nucleo'];
        }
        if ($_POST['vel'] === '') {
            $velocidad = null;
        } else {
            $velocidad = $_POST['vel'];
        }

        $mensaje = "Se grabo correctamente";


        if ($_REQUEST['modo'] == "ins") {
            $consulta = mysql_query("SELECT MAX(id_componente) AS id FROM componente");
            if ($row = mysql_fetch_row($consulta)) {
                $id = trim($row[0]) + 1;
            }
            $consulta = mysql_query("Insert into componente (id_componente,id_tipo_componente, "
                    . "descripcion, id_marca,anio_adquisicion, mes_adquisicion,id_proveedor,"
                    . "nro_serie,id_sistema_informatico,baja,fecha_instalacion,fecha_baja,id_subcomponente) values (" . $id . ", 13, '" . $modelo . "'," . $marca . "," . $año . "," . $mes . ",null," . $nroSerie . "," . $Sistema . ",0,sysdate(),null," . $idSubcomponente . ")");

            #Detalle de velocidad

            if ($_POST['vel'] === '') {
                
            } else {
                $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
                if ($row = mysql_fetch_row($consulta)) {
                    $idDetalle = trim($row[0]) + 1;
                }
                $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, valor,id_descipcion, id_unidad_medida) values(" . $idDetalle . "," . $id . ",'" . $velocidad . "', 7, 2)");
            }

            #Detalle de capacidad

            if ($_POST['nucleo'] === '') {
                
            } else {
                $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
                if ($row = mysql_fetch_row($consulta)) {
                    $idDetalle = trim($row[0]) + 1;
                }
                $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, valor,id_descipcion) values(" . $idDetalle . "," . $id . ",'" . $nucleos . "', 6)");
            }

            #Detalle de subcomponente
            $consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
            if ($row = mysql_fetch_row($consulta)) {
                $idDetalle = trim($row[0]) + 1;
            }
            $consulta = mysql_query("Insert into detalle_componente(id_detalle_componente, id_componente, id_subcomponente) values(" . $idDetalle . ", " . $_POST['SI'] . "," . $id . " )");
        }if ($_REQUEST['modo'] == "mod") {
            $consulta = mysql_query("SELECT id_componente AS id FROM componente where id_tipo_componente = 13 and id_sistema_informatico=" . $_SESSION['si']);
            while ($row = mysql_fetch_array($consulta)) {
                $idComponente = $row['id'];
            }

            $consulta = mysql_query("UPDATE componente SET descripcion='" . $modelo . "' ,id_marca=" . $marca . " ,anio_adquisicion=" . $año . " ,mes_adquisicion=" . $mes . ",nro_serie=" . $nroSerie . " WHERE id_componente =" . $idComponente);

            if ($_POST['nucleo'] === '') {
                echo 'no entra a conexion';
            } else {
                $nucleos = $_POST['nucleo'];
                $consulta = mysql_query("Update detalle_componente set valor='" . $nucleos . "' where id_componente=" . $idComponente . " and id_descipcion=6");
            }
            if ($_POST['vel'] === '') {
                echo 'no entra a conexion';
            } else {
                $velocidad = $_POST['vel'];
                $consulta = mysql_query("Update detalle_componente set valor='" . $velocidad . "' where id_componente=" . $idComponente . " and id_descipcion=7");
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