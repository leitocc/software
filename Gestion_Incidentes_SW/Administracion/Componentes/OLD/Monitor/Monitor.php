<?php

session_start();
try {
    require_once '../../../Conexion.php';
    if ($_REQUEST['modo'] == "del") {
        $consulta = mysql_query("SELECT id_componente AS id FROM componente where id_tipo_componente = 1 and baja=0 and id_sistema_informatico=" . $_SESSION['si']);
        while ($row = mysql_fetch_array($consulta)) {
            $idComponente = $row['id'];
        }

        $consulta = mysql_query("UPDATE componente SET baja=1, fecha_baja=Sysdate() WHERE id_componente=" . $idComponente);
        //echo "UPDATE Componente SET baja=1, fecha_baja=Sysdate() WHERE id_componente=".$idComponente;
        $mensaje = "Se borro correctamente el componente";
    } else {
        if ($_POST['SI'] === '') {
            $Sistema = 'null';
        } else {
            $Sistema = $_POST['SI'];
        }

        if ($_POST['modelo'] === '') {
            $modelo = 'null';
        } else {
            $modelo = $_POST['modelo'];
        }

        if ($_POST['nroSerie'] === '') {
            $nroSerie = 'null';
        } else {
            $nroSerie = "'" . $_POST['nroSerie'] . "'";
        }

        if ($_POST['marca'] === 'Ninguno') {
            $marca = 'null';
        } else {
            $marca = $_POST['marca'];
        }

        if ($_POST['mes'] === 'Ninguno') {
            $mes = 'null';
            ;
        } else {
            $mes = $_POST['mes'];
        }

        if ($_POST['año'] === '') {
            $año = 'null';
        } else {
            $año = $_POST['año'];
        }

        if ($_POST['conexion'] === 'Ninguno') {
            $conexion = null;
        } else {
            $conexion = $_POST['conexion'];
        }

        if ($_POST['proveedor'] === 'Ninguno') {
            $proveedor = 'null';
        } else {
            $proveedor = $_POST['proveedor'];
        }
        $nroInventario = 'null';
        $inventario = filter_input(INPUT_POST, "inventariado");
        if ($inventario === "si") {
            $nroInventario = "'" . filter_input(INPUT_POST, "NroInventario") . "'";
        }
        //$mensaje = "Se grabo correctamente";
        echo $Sistema . " - " . $modelo . " - " . $nroSerie . " - " . $marca . " - " . $mes . " - " . $año . " - " . $nroInventario . " - " . $conexion . " - " . $proveedor . "<br/>";




        if ($_REQUEST['modo'] === "ins") {
            $consulta = mysql_query("SELECT MAX(id_componente) AS id FROM componente");
            if ($row = mysql_fetch_row($consulta)) {
                $id = trim($row[0]) + 1;
            } else {
                $id = 1;
            }
            echo $id . "<br/>";
            //echo "Insert into Componente (id_componente,id_tipo_componente, descripcion, id_marca,anio_adquisicion, mes_adquisicion,id_proveedor,nro_patrimonio,nro_serie,id_sistema_informatico) values (".$id.",1,'".$modelo."','".$marca."',".$año.",".$mes.",null,".$nroInventario.",'".$nroSerie."','".$Sistema."')";
            $queryComponente = "Insert into componente (id_componente,id_tipo_componente, descripcion, id_marca,anio_adquisicion, mes_adquisicion,id_proveedor,nro_patrimonio,nro_serie,id_sistema_informatico,baja,fecha_instalacion) values (" . $id . ",1,'" . $modelo . "','" . $marca . "'," . $año . "," . $mes . ",null," . $nroInventario . "," . $nroSerie . ",'" . $Sistema . "',0,Sysdate())";
            echo $queryComponente . "<br/>";
            $consulta = mysql_query($queryComponente);
            //echo "Insert into componente (id_componente,id_tipo_componente, descripcion, id_marca,anio_adquisicion, mes_adquisicion,id_proveedor,nro_patrimonio,nro_serie,id_sistema_informatico,baja,fecha_instalacion,fecha_baja) values (".$id.",1,'".$modelo."','".$marca."',".$año.",".$mes.",null,".$nroInventario.",'".$nroSerie."','".$Sistema."',0,Sysdate(),null)";
            #Detalle de medida de monitor
            if ($_POST['medida'] === '') {
                echo 'no entra a medida';
            } else {
                $medida = $_POST['medida'];
                $consulta2 = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM detalle_componente");
                if ($row = mysql_fetch_row($consulta2)) {
                    $idDetalle = trim($row[0]) + 1;
                    $consulta2 = "Insert into detalle_componente(id_detalle_componente, id_componente, valor,id_unidad_medida,id_descipcion) values(" . $idDetalle . "," . $id . "," . $medida . ",7,5)";
                    mysql_query($consulta2);
                    echo $consulta2 . "<br/>";
                }
            }

            #Detalle de tipo de conexion

            if ($_POST['conexion'] === 'Ninguno') {
                echo 'no entra a conexion';
            } else {
                $conexion = $_POST['conexion'];
                //$consulta = mysql_query("SELECT MAX(id_detalle_componente) AS id FROM Detalle_Componente");
                //if ($row = mysql_fetch_row($consulta)) {
                //$idDetalle = trim($row[0])+1;}
                $idDetalle = $idDetalle + 1;
                $consulta3 = "Insert into detalle_componente(id_detalle_componente, id_componente, valor_alfanumerico,id_descipcion) values(" . $idDetalle . "," . $id . ",'" . $conexion . "',3)";
                mysql_query($consulta3);
                echo $consulta3 . "<br/>";
            }
            $mensaje = "Se grabo correctamente el monitor ";
        }
        if ($_REQUEST['modo'] == "mod") {
            $consulta = mysql_query("SELECT id_componente AS id FROM componente where id_tipo_componente = 1 and id_sistema_informatico=" . $_SESSION['si']);
            while ($row = mysql_fetch_array($consulta)) {
                $idComponente = $row['id'];
            }

            $consulta = mysql_query("UPDATE componente SET descripcion='" . $modelo . "' ,id_marca=" . $marca . " ,anio_adquisicion=" . $año . " ,mes_adquisicion=" . $mes . ",nro_patrimonio= " . $nroInventario . ",nro_serie=" . $nroSerie . " WHERE id_componente =" . $idComponente);
            if ($_POST['medida'] === '') {
                
            } else {
                $medida = $_POST['medida'];
                $consulta = mysql_query("Update detalle_componente set valor=" . $medida . " where id_componente=" . $idComponente . " and id_descipcion=5");
            }

            if ($_POST['conexion'] === 'Ninguno') {
                echo 'no entra a conexion';
            } else {
                $conexion2 = $_POST['conexion'];
                $consulta = mysql_query("Update detalle_componente set valor_alfanumerico='" . $conexion2 . "' where id_componente=" . $idComponente . " and id_descipcion=3");
            }

            $mensaje = "Se actualizo correctamente el componente";
        }
    }
} catch (Exception $e) {
    echo 'todo mal aca';
    $mensaje = "Error al grabar en la BD";
} catch (mysqli_sql_exception $myE) {
    echo "lalalal";
    echo $myE;
    $mensaje = "Error al grabar en la BD";
}
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/Administracion/Componentes/ModificarComponentesSI.php');
$_SESSION['mensaje'] = $mensaje;
