<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formatoFecha
 *
 * @author Leonardo
 */
class formatoFecha {
    public function convertirAFechaBD($fechaWeb){
        $dia = substr($fechaWeb, 0,2);
        $mes = substr($fechaWeb, 3,2);
        $año = substr($fechaWeb, 6,4);
        $hora = substr($fechaWeb, 11);
        $fechaBD = $año."-".$mes."-".$dia." ".$hora;
        return $fechaBD;
    }
    
    public function convertirAFechaWeb($fechaBD){
        $año = substr($fechaBD, 0,4);
        $mes = substr($fechaBD, 5,2);
        $dia = substr($fechaBD, 8,2);
        $hora = substr($fechaBD, 11, 5);
        $fechaWeb = $dia."/".$mes."/".$año." ".$hora;
        return $fechaWeb;
    }
    
    public function convertirAFechaSolaBD($fechaWeb){
        $dia = substr($fechaWeb, 0,2);
        $mes = substr($fechaWeb, 3,2);
        $año = substr($fechaWeb, 6,4);
        $fechaBD = $año."-".$mes."-".$dia;
        return $fechaBD;
    }
    
    public function convertirAFechaSolaWeb($fechaBD){
        $año = substr($fechaBD, 0,4);
        $mes = substr($fechaBD, 5,2);
        $dia = substr($fechaBD, 8,2);
        $hora = substr($fechaBD, 11, 5);
        $fechaWeb = $dia."/".$mes."/".$año." ".$hora;
        return $fechaWeb;
    }
    
    public function nombreMes($numMes) {
        switch ($numMes){
           case 1: 
               $mes = "Enero";
               break;
           case 2: 
               $mes = "Febrero";
               break;
           case 3: 
               $mes = "Marzo";
               break;
           case 4: 
               $mes = "Abril";
               break;
           case 5: 
               $mes = "Mayo";
               break;
           case 6: 
               $mes = "Junio";
               break;
           case 7: 
               $mes = "Julio";
               break;
           case 8: 
               $mes = "Agosto";
               break;
           case 9: 
               $mes = "Septiembre";
               break;
           case 10: 
               $mes = "Octubre";
               break;
           case 11: 
               $mes = "Noviembre";
               break;
           case 12: 
               $mes = "Diciembre";
               break;
           default:
               $mes = "Enero";
               break;
       }
       return $mes;
    }
    
}
