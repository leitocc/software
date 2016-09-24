<?php

require_once '../Conexion.php';
$mjs = "";
if (isset($_REQUEST['modo']) && $_REQUEST['modo'] == "del") {
    if ($_POST['si'] === '') {
        $id = null;
        $guardar = false;
    } else {
        $id = $_POST['si'];
    }
    $consulta = mysql_query("UPDATE sistema_informatico SET baja=1 WHERE id_sistema_informatico=" . $id);
    $mjs = 3;
} else {
    
    if ($_REQUEST['modo'] == "modi") {
        echo "entre";
        if ($_POST['si'] !== '' && $_POST['siDestino'] !== '') {
            require_once '../Conexion2.php';
            $siOrigen = $_POST['si'];
            $siDestino = $_POST['siDestino'];
            $queryModificacion = "UPDATE sistema_informatico SET id_sistema_informatico= " . $siDestino . " where id_sistema_informatico= " . $siOrigen;
            $update_row = $mysqli->query($queryModificacion);
            if ($update_row) {
                echo"<script type=\"text/javascript\">alert('Se ha modificado el sistema informatico'); "
                . "window.location='/IncidentesSoftware/SistemaInformatico/PrincipalSistemaInformatico.php';</script>"; 
            }else{
                echo"<script type=\"text/javascript\">alert('No se a podido modificar el sistema informatico por que ya tiene asignada un incidente'); "
                . "window.location='/IncidentesSoftware/SistemaInformatico/PrincipalSistemaInformatico.php';</script>";
            }
        }
    } else {
        $guardar = true;
        #Validacion artesanal

        if ($_REQUEST['id'] === '') {
            $id = null;
            $guardar = false;
        } else {
            $id = $_POST['id'];
        }

        if ($_POST['sala'] === '') {
            $sala = null;
            $guardar = false;
        } else {
            $sala = $_POST['sala'];
        }
        //echo "sala: ".$sala." - si: ".$id;
        if ($guardar) {
            require_once '../Conexion.php';
            $consultaSI = "SELECT id_sistema_informatico FROM sistema_informatico SI WHERE id_sala=" . $sala . " AND id_sistema_informatico = " . $id;
            $query1 = mysql_query($consultaSI);
            //echo $consultaSI;
            if (mysql_errno() == 0 && mysql_affected_rows() > 0) {
                //Dar de alta si ya existia el SI
                $darAlta = mysql_query("UPDATE sistema_informatico SET baja = 0 WHERE id_sistema_informatico=" . $id);
                $mjs = 1;
                echo"<script type=\"text/javascript\">alert('Ha ingresado un sistema informatico ya existente'); "
                . "window.location='/IncidentesSoftware/SistemaInformatico/PrincipalSistemaInformatico.php';</script>";
            } else {
                $query = "insert into sistema_informatico (id_sistema_informatico, id_sala,baja) values (" . $id . " , " . $sala . ", 0)";
                $consulta = mysql_query($query);
                $mjs = 1;
                header('Location: /IncidentesSoftware/SistemaInformatico/PrincipalSistemaInformatico.php?mjs=' . $mjs . '');
            }
        } else {

            $mjs = 0;
        }
    }
}
header('Location: /IncidentesSoftware/SistemaInformatico/PrincipalSistemaInformatico.php?mjs='.$mjs.''); 