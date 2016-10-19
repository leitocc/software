<?php if (isset($_SESSION['usuario'])) { ?>
    <div id="header">
        <div class="clearer">&nbsp;</div>
        <div id="site-title">
            <div class="mit_t"> .: Laboratorio de Sistemas :. </div>
        </div>
        <div class="navigation">
            <div class="main-nav">
                <ul class="tabbed">
                    <li class="current-tab"><a href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/index.php"><span>Inicio</span></a></li>
                    <li><a href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/SistemaInformatico/PrincipalSistemaInformatico.php"><span>Sistemas Informáticos</span></a></li>
                    <li><a href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Incidentes/InicioIncidentes.php"><span>Incidentes</span></a></li>
                    <li><a href="/<?php echo $_SESSION['RELATIVE_PATH'] ?>/Administracion/PrincipalAdministracion.php"><span>Administración</span></a></li>
                </ul>
                <div class="clearer">&nbsp;</div>
            </div>
        </div>
    </div>
    <?php
}?>