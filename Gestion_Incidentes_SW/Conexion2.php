<?php

$hostname = 'localhost';
$database = 'gestion_incidentes';
$username = 'leocic';
$password = 'NoHocaj0';

/*$host='localhost';
$user = 'leocic';
$pw = 'NoHocaj0';
$db= 'gestion_incidentes';        //En duotronic*/
       
$mysqli = new mysqli($hostname, $username, $password, $database);
if ($mysqli -> connect_errno) {
die( "Fallo la conexión a MySQL: (" . $mysqli -> mysqli_connect_errno() 
. ") " . $mysqli -> mysqli_connect_error());
}
//else
//echo "Conexión exitosa!";
//$mysqli -> mysqli_close();

