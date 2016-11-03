<?php
session_start();
$permisos = array("6", "1");
$_SESSION['permisos'] = $permisos;
include_once '../../verificarPermisos.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Administración - Buscar Marca</title>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/js/jquery.validate.js"></script>
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/estilo.css" />
        <link rel="stylesheet" type="text/css" href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/css/jquery-ui.css" />
        <script>
            $(document).ready(function () {
                $("#volver").click(function (mievento) {
                    mievento.preventDefault();
                    window.location = '../PrincipalAdministracion.php';
                });
            });
        </script>
    </head>
    <body id="top">
        <?php include_once '../../master.php'; ?>
        <div id="site">
            <div class="center-wrapper">
                <?php include_once '../../menu.php'; ?>

                <div class="main">
                    <div class="post">
                        <form name="formulario" id="formulario" action="ABMMarca.php?modo=mod" method="post" class="contact_form">
                            <?php
                            require_once '../../Conexion2.php';
                            ?>
                            <li><h2>Buscar Marca</h2></li>
                            <li>
                                <label for="marca">Marca:</label>
                                <?php $consulta = "select id_marca As id, descripcion from marca" ?>
                                <?php $resultado10 = $mysqli->query($consulta); ?>
                                <select name="marca" id="marca" required>
                                    <option value="" >Seleccione...</option>
                                    <?php while ($row = $resultado10->fetch_assoc()) { ?>
                                        <option value ="<?php echo $row['id'] ?>"><?php echo $row['descripcion'] ?></option>
                                    <?php } ?>
                                </select>
                            </li>
                            <li>
                                <button type="submit" id="volver" class="submit">Volver</button>
                                <button class="submit" type="submit" name="siguiente" id="siguiente">Buscar</button>
                            </li>
                        </form>
                    </div>
                </div>
                <?php include_once '../../foot.php'; ?>
            </div>
        </div>
    </body>
</html>