<?php
require_once '../Conexion.php';
$mjs = "";
if(isset($_REQUEST['modo']) && $_REQUEST['modo'] =="del"){
    if ($_POST['si'] === '') {
        $id = null;
        $guardar = false;
    } else {
        $id = $_POST['si'];
    }
    $consulta = mysql_query("UPDATE Sistema_Informatico SET baja=1 WHERE id_sistema_informatico=".$id);
    $mjs = 3;
}else{
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
    echo "sala: ".$sala." - si: ".$id;
    if ($guardar) {
        require_once '../Conexion.php';
        $consultaSI ="SELECT id_sistema_informatico FROM sistema_informatico SI WHERE id_sala=".$sala." AND id_sistema_informatico = ".$id;
        $query1 =  mysql_query($consultaSI);
        //echo $consultaSI;
        if(mysql_errno() == 0 && mysql_affected_rows() > 0){
            //Dar de alta si ya existia el SI
            $darAlta = mysql_query("UPDATE sistema_informatico SET baja = 0 WHERE id_sistema_informatico=".$id);
            $mjs = 1;
        }else{
            $query = "insert into sistema_informatico (id_sistema_informatico, id_sala,baja) values (" . $id . " , " . $sala .  ", 0)";
            $consulta = mysql_query($query);
            $mjs = 1;
        }
    } else {
        $mjs = 0;
    }
}
header('Location: /incidentes/SistemaInformatico/PrincipalSistemaInformatico.php?mjs='.$mjs.''); 