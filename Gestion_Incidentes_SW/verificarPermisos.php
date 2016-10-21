<?php
$_SESSION['RELATIVE_PATH'] = explode("/", dirname($_SERVER["PHP_SELF"]))[1];
if (!isset($_SESSION['usuario'])) {
    //falta solucionar que redirija bien login
    ?>
    <script languaje="javascript">
    //alert("Debe registrarse primero");
        location.href = "/<?php echo $_SESSION['RELATIVE_PATH'] ?>/login.php";
    </script>
    <?php

    exit();
} elseif (isset($_SESSION['permisos'])) {
    //hacer una busqueda que contenga el rol del usuario
    if (!in_array($_SESSION['idRolUS'], $_SESSION['permisos'])) {
        ?>
        <script languaje="javascript">
            alert("No tiene permisos para acceder a esta página");
            history.back();
        </script>
        <?php

        exit();
    }
}
