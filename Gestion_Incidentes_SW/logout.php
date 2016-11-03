<?php

//Crear sesión
session_start();
//Vaciar sesión
$_SESSION = array();
//Destruir Sesión
session_destroy();
//Redireccionar a login.php
$RELATIVE_PATH = "incidentes";//explode("/", dirname($_SERVER["PHP_SELF"]))[1];
header("location: /" . $RELATIVE_PATH . "/login.php");

