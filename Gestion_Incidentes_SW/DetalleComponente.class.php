<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DetalleComponente
 *
 * @author Leonardo
 */
class DetalleComponente {

    private $id_detalle;
    private $id_componente;
    private $id_descripcion;
    private $valor;
    private $valor_alfanumerico;
    private $id_unidad_medida;

    public function __constructor() {
        $this->id_detalle = NULL;
        $this->id_componente = NULL;
        $this->id_descripcion = NULL;
        $this->valor = "";
        $this->valor_alfanumerico = "";
        $this->id_unidad_medida = NULL;
    }

    /* public function __constructorValor($valor){
      $this->id_detalle = NULL;
      $this->id_componente = NULL;
      $this->id_descripcion = NULL;
      $this->valor = $valor;
      $this->valor_alfanumerico = "";
      $this->id_unidad_medida = NULL;
      }
      public function __constructorValorAlfanumerico($valorAlfa){
      $this->id_detalle = NULL;
      $this->id_componente = NULL;
      $this->id_descripcion = NULL;
      $this->valor = "";
      $this->valor_alfanumerico = $valorAlfa;
      $this->id_unidad_medida = NULL;
      } */

    function getId_detalle() {
        return $this->id_detalle;
    }

    function getId_componente() {
        return $this->id_componente;
    }

    function getId_descripcion() {
        return $this->id_descripcion;
    }

    function getValor() {
        return $this->valor;
    }

    function getValor_alfanumerico() {
        return $this->valor_alfanumerico;
    }

    function getId_unidad_medida() {
        return $this->id_unidad_medida;
    }

    function setId_detalle($id_detalle) {
        $this->id_detalle = $id_detalle;
    }

    function setId_componente($id_componente) {
        $this->id_componente = $id_componente;
    }

    function setId_descripcion($id_descripcion) {
        $this->id_descripcion = $id_descripcion;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setValor_alfanumerico($valor_alfanumerico) {
        $this->valor_alfanumerico = $valor_alfanumerico;
    }

    function setId_unidad_medida($id_unidad_medida) {
        $this->id_unidad_medida = $id_unidad_medida;
    }

}
