<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Componente
 *
 * @author Leonardo
 */
class Componente {

    private $id_componente;
    private $tipo_componente;
    private $descripcion;
    private $id_marca;
    private $año;
    private $mes;
    private $nro_patrimonio;
    private $nro_serie;
    private $id_sistema_informatico;
    private $fecha_instalacion;
    private $baja;
    private $fecha_baja;

    function __construct() {
        $this->id_componente = NULL;
        $this->tipo_componente = NULL;
        $this->descripcion = "";
        $this->id_marca = "";
        $hoy = getdate();
        $this->año = $hoy['year'];
        $this->mes = "";
        $this->nro_patrimonio = "";
        $this->nro_serie = "";
        $this->id_sistema_informatico = NULL;
        $this->fecha_instalacion = NULL;
        $this->baja = NULL;
        $this->fecha_baja = NULL;
    }

    function __construct2($id, $modelo, $anio, $mes, $patrimonio, $serie) {
        $this->id_componente = $id;
        $this->tipo_componente = NULL;
        $this->descripcion = $modelo;
        $this->id_marca = "";
        $this->año = $anio;
        $this->mes = $mes;
        $this->nro_patrimonio = $patrimonio;
        $this->nro_serie = $serie;
        $this->id_sistema_informatico = NULL;
        $this->fecha_instalacion = NULL;
        $this->baja = NULL;
        $this->fecha_baja = NULL;
    }

    function getId_componente() {
        return $this->id_componente;
    }

    function getTipo_componente() {
        return $this->tipo_componente;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getId_marca() {
        return $this->id_marca;
    }

    function getAño() {
        return $this->año;
    }

    function getMes() {
        return $this->mes;
    }

    function getNro_patrimonio() {
        return $this->nro_patrimonio;
    }

    function getNro_serie() {
        return $this->nro_serie;
    }

    function getId_sistema_informatico() {
        return $this->id_sistema_informatico;
    }

    function getFecha_instalacion() {
        return $this->fecha_instalacion;
    }

    function getBaja() {
        return $this->baja;
    }

    function getFecha_baja() {
        return $this->fecha_baja;
    }

    function setId_componente($id_componente) {
        $this->id_componente = $id_componente;
    }

    function setTipo_componente($tipo_componente) {
        $this->tipo_componente = $tipo_componente;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setId_marca($id_marca) {
        $this->id_marca = $id_marca;
    }

    function setAño($año) {
        $this->año = $año;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function setNro_patrimonio($nro_patrimonio) {
        $this->nro_patrimonio = $nro_patrimonio;
    }

    function setNro_serie($nro_serie) {
        $this->nro_serie = $nro_serie;
    }

    function setId_sistema_informatico($id_sistema_informatico) {
        $this->id_sistema_informatico = $id_sistema_informatico;
    }

    function setFecha_instalacion($fecha_instalacion) {
        $this->fecha_instalacion = $fecha_instalacion;
    }

    function setBaja($baja) {
        $this->baja = $baja;
    }

    function setFecha_baja($fecha_baja) {
        $this->fecha_baja = $fecha_baja;
    }

}
