<?php
$hoy = getdate();
?>
<div id="network">
    <div class="center-wrapper">
        <div class="left">
            <span class="login-from"><?php echo $hoy['weekday'].", ".$hoy['mday']." de ".$hoy['month']." de ".$hoy['year']?></span>            
        </div>
    <div class="right">
        <?php if(!isset($_SESSION['usuario'])){?>
        <form action="comprobar.php" method="post" class="login-from">
            <input type="text" name="usuario" value="" class="login-input" placeholder="Usuario" tabindex="1" />
            <input type="password" name="clave" value="" class="login-input" placeholder="Contraseña" tabindex="2" />
            <input type="submit" name="btnLogin" value="Enviar" class="login-submit" tabindex="3" />
        </form>
        <?php }else{?>
        <span class="text-separator">|</span>
        <span class="quiet">Bienvenido: <?php echo $_SESSION['rolUS']?> - <?php echo $_SESSION['apellidoUS'].", ".$_SESSION['nombreUS']?></span>
        <span class="text-separator">|</span>
        <span class="quiet"><a href="/IncidentesSoftware/logout.php" id="logout" class="more">Salir</a></span>
        <?php }?>
    </div>
    <div class="clearer">&nbsp;</div>
    </div>
</div>

