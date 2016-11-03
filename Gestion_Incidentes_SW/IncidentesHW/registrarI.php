<?php

require_once '../formatoFecha.class.php';

function paginaError($nroError) {
    header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/error.php?error=' . $nroError . '');
}

#Validacion artesanal

if ($_REQUEST['nroIncidente'] != "") {
    $nroIncidente = $_REQUEST['nroIncidente'];
} else {
    //header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/error.php?error=1'); 
    paginaError(1);
}

if ($_REQUEST['fecha'] != "") {
    $fecha = $_REQUEST['fecha'];
    $fecha = formatoFecha::convertirAFechaBD($fecha);
} else {
    paginaError(1);
}

if ($_REQUEST['turno'] != '') {
    $turno = $_REQUEST['turno'];
} else {
    paginaError(1);
}

if ($_REQUEST['institucion'] != '') {
    $institucion = $_REQUEST['institucion'];
} else {
    paginaError(1);
}

if ($_REQUEST['edificio'] != '') {
    $edificio = $_REQUEST['edificio'];
} else {
    paginaError(1);
}

if ($_REQUEST['sala'] != '') {
    $sala = $_REQUEST['sala'];
} else {
    paginaError(1);
}

if ($_REQUEST['si'] != '') {
    $si = $_REQUEST['si'];
} else {
    paginaError(1);
}

if ($_REQUEST['causa'] != '') {
    $causa = $_REQUEST['causa'];
} else {
    paginaError(1);
}

if ($_REQUEST['reporto'] != '') {
    $reporto = $_REQUEST['reporto'];
} else {
    paginaError(1);
}

if ($_REQUEST['area'] != '') {
    $area = $_REQUEST['area'];
} else {
    paginaError(1);
}

if ($_REQUEST['descripcion'] != '') {
    $descripcion = $_REQUEST['descripcion'];
} else {
    paginaError(1);
}

if (isset($_REQUEST['preguntaAct']) && $_REQUEST['preguntaAct'] != '') {
    $preguntaAct = $_REQUEST['preguntaAct'];
    //echo "Pregunta vale: ".$preguntaAct."<br/>";
    if ($preguntaAct == "1") { //0: No - 1: Si
        //echo "ENTRO!!!";
        if ($_REQUEST['nombreAct'] != '') {
            $nombreAct = $_REQUEST['nombreAct'];
        } else {
            paginaError(1);
        }
        if ($_REQUEST['nivel'] != '') {
            $nivel = $_REQUEST['nivel'];
        } else {
            $nivel = "NULL";
        }
        if ($_REQUEST['responsable1'] != '') {
            $responsable1 = $_REQUEST['responsable1'];
        } else {
            $responsable1 = "NULL";
        }
        if ($_REQUEST['responsable2'] != '') {
            $responsable2 = $_REQUEST['responsable2'];
        } else {
            $responsable2 = "NULL";
        }
        $idActividad['id'] = "si";
    } else {
        //echo "NO ENTRO NADA!!!";
        $idActividad['id'] = "NULL";
        //$nombreAct= NULL;
        /* $nivel=NULL;
          $responsable1=NULL;
          $responsable2=NULL; */
    }
} else {
    paginaError(1);
}


require_once '../Conexion.php';
//mysqli_begin_transaction();
$consultaNroInc = "SELECT MAX(I.id_incidente) AS id
                  FROM incidente I";
$query1 = mysql_query($consultaNroInc);
if (mysql_errno() == 0) {
    $id = mysql_fetch_array($query1);
} else {
    $id['id'] = 0;
}
$id['id'] ++;

//primero debo insertar la actividad si es que hubo alguna
//echo $idActividad['id'];
if ($idActividad['id'] != "NULL") {
    $consultaIdAct = "SELECT MAX(A.id_actividad) AS id
                     FROM actividad A";
    $query2 = mysql_query($consultaIdAct);
    if (mysql_errno() == 0) {
        $idActividad = mysql_fetch_array($query2);
    } else {
        $idActividad['id'] = 0;
    }
    $idActividad['id'] ++;
    $insertQuery = "INSERT INTO `actividad`
                    (`id_actividad`,
                    `nombre_actividad`,
                    `nivel_actividad`,
                    `responsable1`,
                    `responsable2`)
                    VALUES
                    (" . $idActividad['id'] . ",
                    \"" . $nombreAct . "\",
                    " . $nivel . ",
                    \"" . $responsable1 . "\",
                    \"" . $responsable2 . "\")";
    $insertActividad = mysql_query($insertQuery);
    echo "Actividad: " . $insertQuery . "<br/><br/>";
}



//se debe quietar el id persona que registro

$insertQuery = "INSERT INTO incidente
(`id_incidente`,
`id_sistema_informatico_afectado`,
`fecha`,
`id_turno`,
`id_sala`,
`descripcion`,
`id_causa_incidente`,
`id_estado`,
`id_actividad_en_desarrollo`,
`id_persona_reporto`,
`id_rol_persona_reporto`)
VALUES
(" . $id['id'] . ",
" . $si . ",
\"" . $fecha . "\",
" . $turno . ",
" . $sala . ",
\"" . $descripcion . "\",
" . $causa . ",
1,
" . $idActividad['id'] . ",
" . $reporto . ",
" . $area . ")";
$insert = mysql_query($insertQuery);
echo "Incidentes: " . $insertQuery;
//mysqli_commit($insert);
/**/if (mysql_errno() == 0) {
    header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/IncidentesHW/InicioIncidentes.php?msj=1');
} else {
    header('Location: /' . $_SESSION['RELATIVE_PATH'] . '/IncidentesHW/InicioIncidentes.php?msj=0');
}/**/

