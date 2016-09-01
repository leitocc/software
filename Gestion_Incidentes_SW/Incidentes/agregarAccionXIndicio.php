<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
$idAccion = filter_input(INPUT_GET, "idAccion");
require_once '../Conexion2.php';
$queryAccion = "SELECT idAccion, nombre "
        . "FROM accion_correctiva_software"
        . "WHERE idAccion = " . $idAccion;//esto hay que cambiarlo xq es para indicio!!

//echo $queryIncidente . "</br>";
$buscarAccion = $mysqli->query($queryAccion);
if (!$buscarAccion) {
    printf("Error en la consulta %s\n", mysql_error());
    exit();
}
$accion = $buscarAccion->fetch_assoc();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agregar nueva acción correctiva</title>
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/IncidentesSoftware/js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="/IncidentesSoftware/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="/IncidentesSoftware/css/jquery-ui.css" />
        <script>
            $(document).ready(function () {

            });
        </script>
    </head>
    <body>
    <body id="top">
        <?php include_once '../../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <div class="main">
                    <div class="post">
                        <form action="registrarAccionCorrectiva.php" method="post" name="formulario" class="contact_form">
                            <div>
                                <ul>
                                    <li><h2>Registrar Accion correctiva de: <?php echo "aqui va el indicio" ?></h2><span class="required_notification">Los campos con (*) son obligatorios</span></li>
                                    <li> <label>(*)Nombre:</label> 
                                        <input name="descripcion" id="descripcion" type="text">
                                    </li>
                                    <li> <label>(*)tipo componente</label>
                                        <select id="tipo_componente_software" name="tipo_componente_software"> 
                                            <option value="">Seleccione...</option>   
                                            <?php
                                            $query = "select tc.idtipocomponente AS id, tc.descripcion from tipo_componente_software tc";
                                            $resultado100 = $mysqli->query($query);
                                            if ($resultado100) {
                                                while ($row = $resultado100->fetch_assoc()) {
                                                    ?>
                                                    <option value ="<?php echo $row['id'] ?>"><?php echo $row['descripcion'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>         
                                    </li>
                                    <li>
                                        <label>( )Version</label>
                                        <input name="version" id="version" type="text"> 
                                    </li>
                                    <li> <button class="submit" type="submit">Guardar</button> <button class="submit" type="submit" id="volver">Volver</button></li> 
                                </ul>                                
                            </div>
                        </form>
                    </div>
                </div>
                <?php include_once '../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>