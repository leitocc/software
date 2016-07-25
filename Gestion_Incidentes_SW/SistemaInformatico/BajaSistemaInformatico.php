<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../verificarPermisos.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistemas Informaticos - Baja</title>
        <script type="text/javascript" src="/Gestion_Incidentes_SW/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/Gestion_Incidentes_SW/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/Gestion_Incidentes_SW/js/jquery.validate.js"></script>
        <link rel="stylesheet" type="text/css" href="/Gestion_Incidentes_SW/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="/Gestion_Incidentes_SW/css/jquery-ui.css" />
        <script>
            $(document).ready(function() {
                $("#sala").change(function(e) {
                    if ($("#sala").val() !== "Seleccione...") {
                        $.ajax({
                            url: "/Gestion_Incidentes_SW/SistemaInformatico/cargarSI.php",
                            type: "POST",
                            data: "sala=" + $("#sala").val(),
                            success: function(opciones) {
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
                $("#Volver").click(function(mievento){
                    mievento.preventDefault();
                    //history.back();
                    window.location = 'PrincipalSistemaInformatico.php';
                });
                $("#confirmar").click(function(mievento){
                    mievento.preventDefault();
                    //if(!$("#formulario").validate()){
                        if(confirm("¿Está seguro que desea dar de baja el SI "+$("#si").val()+"?")){
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
                        <form name="formulario" id="formulario" action="SistemaInformatico.php?modo=del" method="post" class="contact_form">
                            <?php
                            require_once '../Conexion.php';
                            ?>
                            <li><h2>Buscar Sistema Informático</h2></li>
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
                                <button class="submit" type="submit" name="Baja" id="confirmar">Confirmar</button>
                                <button class="submit" type="submit" name="Submit" id="Volver">Volver</button>
                            </li>
                        </form>
                    </div>
                </div>
                <?php include_once './../foot.php'; ?>
            </div>
        </div>
    </body>
</html>