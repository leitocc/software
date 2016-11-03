<?php
//session_start();
//$permisos = array("6", "1");
//$_SESSION['permisos'] = $permisos;
//include_once '../verificarPermisos.php';
//$causa_incidente = filter_input(INPUT_GET, "causa_incidente");
$causa_incidente = $incidente['causa_incidente'];
//require_once '../Conexion2.php';
$consultaAccionesCorrectivas = "SELECT acs.idAccion as id, acs.nombre 
    FROM accion_softwarexcausa_software ascs 
    INNER JOIN accion_correctiva_software acs  on ascs.id_accion=acs.idAccion 
    inner join causa_incidente_software cs on ascs.id_causa=cs.idCausa 
    where cs.nombre='" . $causa_incidente . "'";
$resultadoAcccionesCorrectivas = $mysqli->query($consultaAccionesCorrectivas);

$consultaTodasAccionesCorrectivas = "SELECT acs.idAccion as id, acs.nombre 
    FROM accion_softwarexcausa_software ascs";
$resultadoTodasAcccionesCorrectivas = $mysqli->query($consultaTodasAccionesCorrectivas);
?>
<div id="miVentana" style="position: fixed; width: 350px; height: 190px; top: 0; left: 0; 
     font-family:Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; 
     border: #333333 3px solid; background-color: #FAFAFA; color: #000000; display:none;">
    <form action="registrarAccionCorrectiva.php" method="post" name="formulario" class="contact_form">
        <div>
            <ul>
                <li><h2>Registrar Accion correctiva de: <?php echo $causa_incidente ?></h2><span class="required_notification">Los campos con (*) son obligatorios</span></li>
                <fieldset><legend><h5>El indicio "<?php echo $causa_incidente ?>" contiene las siguientes acciones correctivas:</h5></legend>
                    <div class="archive-separator"></div>
                    <?php
                    if ($resultadoAcccionesCorrectivas) {
                        while ($row = $resultadoAcccionesCorrectivas->fetch_assoc()) {
                            echo "<h4>" . $row['nombre'] . "</h4>";
                        }
                    }
                    ?>
                </fieldset>
                <fieldset><legend><h5>Seleccione nueva accion correctiva:</h5></legend>
                    <div class="archive-separator"></div>
                    <li>
                        <select name="acciones">
                            <option value="">Seleccione...</option>
                            <?php
                            if ($resultadoTodasAcccionesCorrectivas) {

                                while ($row = $resultadoTodasAcccionesCorrectivas->fetch_assoc()) {
                                    if (!in_array($row, $resultadoAcccionesCorrectivas)) {
                                        echo "<option value=" . $row['id'] . ">" . $row['nombre'] . "</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <input type="radio" name="otro" value="No" checked="true"/>
                        <input type="radio" name="otro" value="Si"/>
                    </li>
                    <li> <label>(*)Nombre:</label> 
                        <input name="nombre" id="nombre" type="text" disabled="true">
                    </li>
                    <li> <button class="submit" type="submit" id="volver">Volver</button> <button class="submit" type="submit">Guardar</button> </li> 
                </fieldset>
            </ul>
        </div>
    </form>
</div>
<!--        
                    </div>
                </div>
<?php // include_once '../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>
-->