<?php

session_start();

function paginaError($nroError, $mjs) {
    header('Location: /incidentes/error.php?error=' . $nroError . '&mjs=' . $mjs . '');
    exit();
}

require_once '../formatoFecha.class.php';
#Validacion artesanal

if ($_REQUEST['nroInterv'] != "") {
    $nroInterv = $_REQUEST['nroInterv'];
} else {
    //header('Location: /incidentes/error.php?error=1'); 
    paginaError(1, "1");
}

if ($_REQUEST['finicio'] != "") {
    $finicio = formatoFecha::convertirAFechaSolaBD($_REQUEST['finicio']);
} else {
    paginaError(1, "2");
}

if ($_REQUEST['hinicio'] != "") {
    $hinicio = $_REQUEST['hinicio'];
} else {
    paginaError(1, "hi");
}

if ($_REQUEST['ffin'] != "") {
    $ffin = formatoFecha::convertirAFechaSolaBD($_REQUEST['ffin']);
} else {
    paginaError(1, "ff");
}

if ($_REQUEST['hfin'] != "") {
    $hfin = $_REQUEST['hfin'];
} else {
    paginaError(1, "hf");
}

//$componentes = filter_input(INPUT_POST, "componente[]");
//echo $componentes . "</br>";
//echo "paso" . "</br>";
//foreach ($componentes as $check) {
//    echo $check . "lala</br>";
//    if ($check == "On") {
//        $componente[] = $check;
//        echo "1...";
//        echo $check.value . "</br>";
//    }
//}
//echo printf($componente) . "</br>";

$componente = $_POST["componente"];
/* if (isset($_REQUEST['componente1'])) {
  $componente[] = 1;
  }

  if (isset($_REQUEST['componente2'])) {
  $componente[] = 2;
  }

  if (isset($_REQUEST['componente3'])) {
  $componente[] = 3;
  }
  if (isset($_REQUEST['componente4'])) {
  $componente[] = 4;
  }

  if (isset($_REQUEST['componente5'])) {
  $componente[] = 5;
  }

  if (isset($_REQUEST['componente6'])) {
  $componente[] = 6;
  }

  if (isset($_REQUEST['componente7'])) {
  $componente[] = 7;
  }

  if (isset($_REQUEST['componente8'])) {
  $componente[] = 8;
  }

  if (isset($_REQUEST['componente9'])) {
  $componente[] = 9;
  }

  if (isset($_REQUEST['componente10'])) {
  $componente[] = 10;
  }

  if (isset($_REQUEST['componente11'])) {
  $componente[] = 11;
  }

  if (isset($_REQUEST['componente13'])) {
  $componente[] = 13;
  } */




if ($_REQUEST['descripcionInterv'] != "") {
    $descripcionInterv = $_REQUEST['descripcionInterv'];
} else {
    paginaError(1, "des");
}


if (isset($_REQUEST['accion1'])) {
    $accion[] = 1;
}

if (isset($_REQUEST['accion2'])) {
    $accion[] = 2;
}

if (isset($_REQUEST['accion3'])) {
    $accion[] = 3;
}

if (isset($_REQUEST['accion4'])) {
    $accion[] = 4;
}

if (isset($_REQUEST['accion5'])) {
    $accion[] = 5;
}

if (isset($_REQUEST['accion6'])) {
    $accion[] = 6;
}

if (isset($_REQUEST['accion7'])) {
    $accion[] = 7;
}

if (isset($_REQUEST['accion8'])) {
    $accion[] = 8;
}

if ($_REQUEST['estado'] != "") {
    $estado = $_REQUEST['estado'];
} else {
    paginaError(1, "es");
}

if ($_REQUEST['idIncidente'] != "") {
    $idIncidente = $_REQUEST['idIncidente'];
} else {
    paginaError(1, "idI");
}

if ($_REQUEST['idSI'] != "") {
    $idSI = $_REQUEST['idSI'];
} else {
    paginaError(1, "idSI");
}

require_once '../Conexion.php';

$consultaReporto = "SELECT P.id_persona AS id 
FROM persona P INNER JOIN usuario U ON P.id_persona = U.id_persona 
AND U.usuario = \"" . $_SESSION['usuario'] . "\"";
$queryUsuario = mysql_query($consultaReporto);
$idPersona = "NULL";
if (mysql_errno() == 0) {
    if ($row = mysql_fetch_array($queryUsuario)) {
        $idPersona = $row['id'];
    }
}


//se debe quietar el id persona que registro
//mysqli_autocommit($conexion, false);
mysql_query('BEGIN');
//mysqli_query($conexion, 'BEGIN');
$insertQuery = "INSERT INTO `detalle_intervencion`
(`id_detalle_intervencion`,
`id_incidente`,
`descripcion`,
`fecha_inicio`,
`hora_inicio`,
`fecha_fin`,
`hora_fin`,
`id_persona_detalle_intervencion`)
VALUES
(" . $nroInterv . ",
" . $idIncidente . ",
\"" . $descripcionInterv . "\",
\"" . $finicio . "\",
\"" . $hinicio . "\",
\"" . $ffin . "\",
\"" . $hfin . "\",
\"" . $idPersona . "\")";
$insert = mysql_query($insertQuery);

//echo $insertQuery . "</br>";

if (mysql_errno() != 0) {

    mysql_query('ROLLBACK');
    exit();
    header('Location: /incidentes/Incidentes/InicioIncidentes.php?mjs=0');
}


//-----FUNCIONA!!!!, solo que si no estan cargados los componentes del SI tira error---------
for ($index = 0; $index < count($componente); $index++) {
    $buscarComponente = "SELECT C.id_componente AS id FROM componente C 
    WHERE C.id_tipo_componente = " . $componente[$index] . "
    AND C.id_sistema_informatico = " . $idSI . "
    AND C.baja = 0";
    $buscar = mysql_query($buscarComponente);
    if (mysql_errno() != 0) {
        mysql_query('ROLLBACK');
        header('Location: /incidentes/Incidentes/InicioIncidentes.php?mjs=0');
        exit();
    }
    $idComponente = mysql_fetch_assoc($buscar);
    //echo "IdComp: " . $idComponente['id'] . "</br>";
    //echo print_r($idComponente);

    $insertComponentes = "INSERT INTO `componentexdetalle_intervencion`
    (`id_componente`,
    `id_incidente`,
    `id_detalle_intervencion`)
    VALUES
    (" . $idComponente['id'] . ",
    " . $idIncidente . ",
    " . $nroInterv . ")";
    $insert = mysql_query($insertComponentes);
    echo "Incidentes: " . $insertComponentes . "</br>";
    if (mysql_errno() != 0) {
        echo "ERROR: No se grabo el detalle" . mysql_errno() . "</br>";
        mysql_query('ROLLBACK');
        header('Location: /incidentes/Incidentes/InicioIncidentes.php?mjs=0');
        exit();
    }
}

for ($index = 0; $index < count($accion); $index++) {

    $insertAccion = "INSERT INTO `accion_correctivaxdetalle_intervencion`
    (`id_accion`,
    `id_incidente`,
    `id_detalle_intervencion`)
    VALUES
    (" . $accion[$index] . ",
    " . $idIncidente . ",
    " . $nroInterv . ")";
    $insert = mysql_query($insertAccion);
    if (mysql_errno() != 0) {
        echo print_r($accion);
        echo "ERROR: No se grabo el detalle de accion" . mysql_errno() . "; " . $accion[$index] . "</br>";
        mysql_query('ROLLBACK');
        header('Location: /IncidentesSoftware/Incidentes/InicioIncidentes.php?mjs=0');
        exit();
    }
}
if ($estado != 1) {
    $updateIncidente = "UPDATE incidente 
                        SET id_estado = " . $estado . " 
                        WHERE id_incidente = " . $idIncidente;
    if (!mysql_query($updateIncidente)) {
        echo "ERROR: No se actualizo el estado del incidente" . mysql_errno() . "</br>";
        mysql_query('ROLLBACK');
        header('Location: /IncidentesSoftware/Incidentes/InicioIncidentes.php?mjs=0');
        exit();
    }
}

mysql_query('COMMIT');
//header('Location: /incidentes/Incidentes/InicioIncidentes.php?mjs=1');
