<?php

require_once '../../Conexion2.php';
session_start();

$vectorComponenteSoftware = $_POST["cs"];
$idSala = filter_input(INPUT_POST, "sala");
//echo "idSala: " . $idSala;
//echo "<br/>";
//if(is_array($vectorComponenteSoftware)){
//    echo "si lo es";
//}
//print_r($vectorComponenteSoftware);
foreach ($vectorComponenteSoftware as $componenteSoftware) {
    $msj = 1;
    try {
        $mysqli->autocommit(FALSE);
        $queryComponenteXaula = "INSERT INTO salaxcomponente_software(id_sala,id_componente_software) VALUES(" . $idSala . ", " . $componenteSoftware . ")";
        //echo $queryComponenteXaula;
        if ($mysqli->query($queryComponenteXaula)) {
            echo "nueva ComponenteXaula insertada " . $mysqli->insert_id;
        } else {
            throw new Exception ();
//            $mysqli->rollback();
//            die();
        }
        
    } catch (Exception $ex) {

        echo "todo mal " . $e;
        $mysqli->rollback();
        $mysqli->close();
        $msj = 2;
        exit();
//        die();
    }
}
$mysqli->commit();
$mysqli->close();
header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/Administracion/PrincipalAdministracion.php?msj=' . $msj . '');