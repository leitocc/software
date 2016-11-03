<?php

session_start();
try {
    require_once '../../../Conexion.php';
    $modo = filter_input(INPUT_GET, "modo");
    $mensaje = "";
    if ($modo == "del") {
        $consulta = mysql_query("SELECT id_componente AS id FROM componente WHERE"
                . " id_tipo_componente = 14 AND baja = 0 AND id_sistema_informatico=" . $_SESSION['si']);
        while ($row = mysql_fetch_array($consulta)) {
            $idComponente = $row['id'];
        }
        $consulta = mysql_query("UPDATE componente SET baja=1, fecha_baja=Sysdate() WHERE id_componente=" . $idComponente);
        $mensaje = "Se borro correctamente el componente";
    } else {
        try {
            $Sistema = filter_input(INPUT_POST, "SI");
            $modelo = filter_input(INPUT_POST, "modelo");
            $nroSerie = "'" . filter_input(INPUT_POST, "nroSerie") . "'";
            $marca = filter_input(INPUT_POST, "marca");
            $mes = filter_input(INPUT_POST, "mes");
            $año = filter_input(INPUT_POST, "año");
            $proveedor = filter_input(INPUT_POST, "proveedor");
            $idSubcomponente = filter_input(INPUT_POST, "idSub");
            $potencia = filter_input(INPUT_POST, "potencia");
        } catch (Exception $ex) {
            echo "se rompio por aqui<br/>";
            //header('Location: /incidentes/ErrorFormulario.php'); 
        }
        if ($modo === "ins") {
            $consulta = mysql_query("SELECT MAX(id_componente) AS id FROM componente");
            if ($row = mysql_fetch_row($consulta)) {
                $id = trim($row[0]) + 1;
            } else {
                $id = 1;
            }
            echo $id . "<br/>";
            $queryComponente = "Insert into componente (id_componente,id_tipo_componente, descripcion, "
                    . "id_marca,anio_adquisicion, mes_adquisicion,id_proveedor,nro_patrimonio,"
                    . "nro_serie,id_sistema_informatico,baja,fecha_instalacion,id_subcomponente) "
                    . "values (" . $id . ",14,'" . $modelo . "','" . $marca . "'," . $año . "," . $mes . ",null,null,"
                    . "" . $nroSerie . ",'" . $Sistema . "',0,Sysdate()," . $idSubcomponente . ")";
            echo $queryComponente . "<br/>";
            $consulta = mysql_query($queryComponente);

            #Detalle Potencia
            $consultaMax = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
            if (mysql_errno() == 0) {
                $idDetalle = mysql_fetch_array($consultaMax);
            } else {
                $idDetalle['id'] = 0;
            }
            $idDetalle['id'] ++;
            $insertDetalle = "Insert into detalle_componente(id_detalle_componente, id_componente, "
                    . "valor,id_unidad_medida,id_descipcion) values(" . $idDetalle['id'] . "," . $id . "," . $potencia . ",10,11)";
            mysql_query($insertDetalle);
            echo $insertDetalle . "<br/>";

            $mensaje = "Se grabo correctamente";
        } elseif ($modo == "mod") {
            $consulta = mysql_query("SELECT id_componente AS id FROM componente where id_tipo_componente = 14 and id_sistema_informatico=" . $_SESSION['si']);
            while ($row = mysql_fetch_array($consulta)) {
                $idComponente = $row['id'];
            }
            $consulta = mysql_query("UPDATE componente SET descripcion='" . $modelo . "' ,id_marca=" . $marca . " ,anio_adquisicion=" . $año . " ,mes_adquisicion=" . $mes . ",nro_serie=" . $nroSerie . " WHERE id_componente =" . $idComponente);
            $consulta = mysql_query("UPDATE detalle_componente SET valor=" . $potencia . " where id_componente=" . $idComponente . " and id_descipcion=11");
            $mensaje = "Se actualizo correctamente el componente";
        }
    }
} catch (mysqli_sql_exception $myE) {
    $mensaje = "Error al grabar en la BD: " . $myE;
} catch (Exception $e) {
    $mensaje = "Error general: " . $e;
}
echo $mensaje;
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/Administracion/Componentes/CPU/PaginaCPUSegunda.php');
$_SESSION['mensaje'] = $mensaje;
