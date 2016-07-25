<?php

$host='localhost';
$user = 'leocic';
$pw = 'NoHocaj0';
//$db= 'bd-duotronic';        //local
$db= 'gestion_incidentes_sw';        //En duotronic
       
$conexion = mysql_connect($host, $user, $pw) or die('Fallo');
mysql_select_db($db, $conexion) or die('Fallo aca');
#echo "esto anda... en serio"

