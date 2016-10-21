<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistemas Informaticos - Modificar</title>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery.validate.js"></script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/jquery-ui.css" />
        <script>
            $(document).ready(function () {
                $("#sala").change(function (e) {
                    if ($("#sala").val() !== "Seleccione...") {
                        $.ajax({
                            url: "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/SistemaInformatico/cargarSI.php",
                            type: "POST",
                            data: "sala=" + $("#sala").val(),
                            success: function (opciones) {
                                $("#si").html(opciones).show("slow");
                                //$("#agregarProvincia").attr("hidden", false);
                                //$("#boton").attr("disabled", true);
                            }
                        })
                    } else {
                        $("#si").html("<option>Seleccione...</option>")
                        //$("#selectLocalidad").html("<option>Seleccione...</option>")
                        //$("#agregarProvincia").attr("hidden", true);
                        //$("#boton").attr("disabled", true);
                    }
                });
                $("#Volver").click(function (mievento) {
                    mievento.preventDefault();
                    //history.back();
                    window.location = 'PrincipalSistemaInformatico.php';
                });
                $("#confirmar").click(function (mievento) {
                    mievento.preventDefault();
                    //if(!$("#formulario").validate()){
                    if (confirm("¿Está seguro que quiere modificar el SI " + $("#si").val() + "?")) {
                        $("#formulario").submit();
                    }
                    //}
                    //window.location = 'PrincipalSistemaInformatico.php';
                });
            });
        </script>
    </head>
    <body id="top">
        <?php include_once '../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../menu.php'; ?>

                <div class="main">
                    <div class="post">
                        <form name="formulario" id="formulario" action="SistemaInformatico.php?modo=modi" method="post" class="contact_form">
                            <?php
                            require_once '../Conexion.php';
                            ?>
                            <li><h2>Modificar Sistema Informático</h2></li>
                            <li>
                                <label for="sala">Sala:</label>
                                <?php $consultaSala = "select id_sala, nombre from sala" ?>
                                <?php $query1 = mysql_query($consultaSala) ?>

                                <?php #Primer combo de sala  ?>
                                <select name="sala" id="sala" required>
                                    <option value="" >Seleccione...</option>
                                    <?php while ($row = mysql_fetch_array($query1)) { ?>
                                        <option value ="<?php echo $row['id_sala'] ?>"><?php echo $row['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </li>
                            <li>
                                <label for="si">Identificaci&oacute;n::</label>
                                <select name="si" id="si" required>
                                    <option value="">Seleccione...</option>
                                </select>
                            </li>
                            <li>
                                <label for="siDestino">Nva. Identificaci&oacute;n</label>
                                <input  type="text" id="siDestino" name="siDestino" required> 
                            </li>                           
                            <li>
                                <button class="submit" type="submit" name="Volver" id="Volver">Volver</button>
                                <button class="submit" type="submit" name="confirmar" id="confirmar">Confirmar</button>
                            </li>
                        </form>
                    </div>
                </div>
                <?php include_once './../foot.php'; ?>
            </div>
        </div>
    </body>
</html>