<?php

require_once '../../Conexion2.php';
session_start();

$vectorComponenteSoftware = $_POST["cs"];
$idSala = $_POST["sala"];
foreach ($vectorComponenteSoftware as $componenteSoftware) {
    try {
        $mysqli->autocommit(FALSE);
        $queryComponenteXaula = "DELETE FROM salaxcomponente_software(id_sala,id_componente_software) VALUES(" . $idSala . ", " . $componenteSoftware . ")";
        //echo $queryComponenteXaula;
        if ($mysqli->query($queryComponenteXaula) === TRUE) {
            echo "nueva ComponenteXaula insertada " . $mysqli->insert_id;
        } else {
            throw new Exception ();
            $mysqli->rollback();
            die();
        }
        
    } catch (Exception $ex) {

        echo "todo mal " . $e;
        $mysqli->rollback();
        $mysqli->close();
        die();
    }
}
$mysqli->commit();
$mysqli->close();
?>
