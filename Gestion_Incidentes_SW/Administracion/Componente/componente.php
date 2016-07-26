<?php
session_start();
try{
    require_once '../../Conexion2.php';
    $mensajecomponente= "";
    $descripcion=filter_input(INPUT_POST, "descripcion");
    $tipoComponente=filter_input(INPUT_POST, "tipo_componente_software");
    $version=filter_input(INPUT_POST, "version");
    $query22="INSERT INTO componente_software (id_tipo_componente,descripcion,version) values(".$tipoComponente.",'".$descripcion."','".$version."');";
    echo $query22;
    $consulta=$mysqli->query($query22);
    $mensajecomponente="se registro correctamente";
    //$modo = filter_input(INPUT_POST, "modo");
    //$nombre = filter_input(INPUT_POST, "nombre");
   /* if($modo === "ins"){
        $consultamarca="SELECT MAX(id_marca) AS id FROM marca";
        $resultadoMaxId = $mysqli->query($consultamarca);
        if($row = $consulta->fetch_assoc()){
            $idMarca['id'] = $row["id_marca"];
        }else{
            $idMarca['id'] = 0;
        }
        $idMarca['id']++;
        $queryMarca = "INSERT INTO marca (`id_marca`,`descripcion`) VALUES (".$idMarca['id'].", '".$nombre."');";
        $consultaMarca = $mysqli->query($queryMarca);
        $mensaje = "Se registro correctamente";
    }elseif($modo === "mod"){
        $idMarca = filter_input(INPUT_POST, "idMarca");
        $queryActualizar="UPDATE marca SET descripcion = '".$nombre."' where id_marca = ".$idMarca.";";
        $consulta = $mysqli->query($queryActualizar); 
        $mensaje = "Se actualizo correctamente";
    }else{
        $mensaje = "Error, comuniquese con el administrador";
    }
    * 
    */
    
}catch (mysqli_sql_exception $myE){
    $mensajecomponente = "Error al grabar en la BD: ".$myE;
}catch (Exception $e){
    $mensajecomponente = "Error general: ". $e;
}
echo $mensajecomponente;
header('Location: /IncidentesSoftware/Administracion/PrincipalAdministracion.php');
$_SESSION['mensaje'] = $mensajecomponente;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

