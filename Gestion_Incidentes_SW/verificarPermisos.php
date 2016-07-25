<?php

if (!isset($_SESSION['usuario'])) {
    //falta solucionar que redirija bien login
    ?>
    <script languaje="javascript">
    //alert("Debe registrarse primero");
        location.href = "/Gestion_Incidentes_SW/login.php";
    </script>
    <?php

    //header('Location: /incidentes/login.php'); 
    exit();
} elseif (isset($_SESSION['permisos'])) {
    //hacer una busqueda que contenga el rol del usuario
    if (!in_array($_SESSION['idRolUS'], $_SESSION['permisos'])) {
        //header('Location: /incidentes/login.php'); 
        ?>
        <script languaje="javascript">
            alert("No tiene permisos para acceder a esta página");
            history.back();
        </script>
        <?php

        exit();
    }
}
