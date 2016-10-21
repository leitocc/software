<?php

require_once '../../Conexion2.php';
session_start();

$vectorComponenteSoftware = $_POST["cs"];
$idSala = $_POST["sala"];
foreach ($vectorComponenteSoftware as $componenteSoftware) {
    try {
        $mysqli->autocommit(FALSE);
        $queryComponenteXaula = "INSERT INTO salaxcomponente_software(id_sala,id_componente_software) VALUES(" . $idSala . ", " . $componenteSoftware . ")";
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


<html>
    <head>
        <meta charset="UTF-8">
        <title>RegistrarNuevo</title>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/ajax.js"></script>
    </head>
    <body id="top">
        <?php include_once '../../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../../menu.php'; ?>

                <div class="main">
                    <div class="post">
                        <li class="no_lista">
                            <h1>Se ha registrado correctamente</h1>
                        </li>
                        <table>
                            <tr>

                                <td colspan="2">
                                    <form action="../../index.php">
                                        <button name="volver" id="volver" class="submit">Volver Inicio</button>
                                    </form>
                                </td>
                            </tr>
                        </table>    

                        <div style="width: 600px" id="datos"></div>

                    </div>
                    <?php include_once '../../foot.php'; ?>
                </div>
                </body>
                </html>
