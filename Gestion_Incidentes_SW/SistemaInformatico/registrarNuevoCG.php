<?php

require_once '../Conexion2.php';
require_once '../DetalleComponente.class.php';
session_start();
$vectorComponente = $_SESSION['Componente'];
$vectorDetalles = $_SESSION['Detalles'];

$vectorMaquinas = $_POST["SI"];

foreach ($vectorMaquinas as $maquina) {
    try {
        $mysqli->autocommit(FALSE);
        $query11 = "select max(id_componente)as maximo from componente";
        $resultado = $mysqli->query($query11);
        if ($row = $resultado->fetch_assoc()) {
            $numero = $row["maximo"] + 1;
        }
       // echo $numero . "</br>";
        $query10 = "INSERT INTO Componente(id_componente,id_tipo_componente,id_marca,anio_adquisicion,mes_adquisicion,id_proveedor,id_sistema_informatico,baja) values(" . $numero . ", " . $vectorComponente["idTipoComponente"] . ", " . $vectorComponente["marca"] . ", " . $vectorComponente["anio"] . ", " . $vectorComponente["mes"] . ",null, " . $maquina . ", 0)";
       // echo $query10 . "</br></br></br>";

        if ($mysqli->query($query10) === TRUE) {
            echo "nuevo maquina insertada " . $mysqli->insert_id;
        } else {
            throw new Exception ();
            $mysqli->rollback();
            die();
        }
        if ($vectorDetalles != NULL) {
            foreach ($vectorDetalles as $detalle) {
                $query12 = "select max(id_detalle_componente)as maximo from detalle_Componente";
                $resultado = $mysqli->query($query12);
                if ($row = $resultado->fetch_assoc()) {
                    $numerodetalle = $row["maximo"] + 1;
                }
                //echo $numerodetalle . "</br>";
                $valor = "null";
                $valorAlfa = "null";

                    $valor = $detalle->getValor();
                if ($detalle->getValor() != "") {
                }
                if ($detalle->getValor_alfanumerico() != "") {
                    $valorAlfa = $detalle->getValor_alfanumerico();
                }


                $query11 = "INSERT INTO detalle_Componente(id_Detalle_componente,"
                        . "id_componente,id_descipcion,valor,valor_alfanumerico,id_unidad_medida) "
                        . "values (" . $numerodetalle . ", " . $numero . ", " . $detalle->getId_descripcion()
                        . "," . $valor . ", " . $valorAlfa . ", "
                        . $detalle->getId_unidad_medida() . ")";
             //   echo $query11 . "</br>";
                if ($mysqli->query($query11) === TRUE) {
                    echo "detalle de la  maquina insertada " . $mysqli->insert_id;
                } else {
                    throw new Exception ();
                    $mysqli->rollback();
                    die();
                }
            }
        }
        $mysqli->commit();
    } catch (exception $e) {
        echo "todo mal " . $e;
        $mysqli->rollback();
        die();
    }
}
$mysqli->close();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>RegistrarNuevo</title>
        <link rel="stylesheet" type="text/css" href="/IncidentesSoftware/css/estilo.css" />
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/IncidentesSoftware/js/ajax.js"></script>
    </head>
    <body id="top">
        <?php include_once '../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../menu.php'; ?>

                <div class="main">
                    <div class="post">

                        <li class="no_lista">
                            <h1>Se ha registrado correctamente</h1>
                        </li>
                        <table>
                            <tr>
                                
                                <td colspan="2">
                                    <form action="../index.php">
                                        <button name="volver" id="volver" class="submit">Volver Inicio</button>
                                    </form>
                                </td>
                            </tr>
                        </table>    

                        <div style="width: 600px" id="datos"></div>

                    </div>
                    <?php include_once '../foot.php'; ?>
     </div>
    </body>
   </html>
