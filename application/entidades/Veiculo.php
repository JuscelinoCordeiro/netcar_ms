<?php

    class Veiculo {

        //ATRIBUTOS
        //======================================================================
        private $id;
        private $tipo;

        //METODOS MAGICOS
        //======================================================================
        public function __get($valor) {
            return $this->$valor;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        //METODOS SET
        //======================================================================
        public function setCodigo($id) {
            $this->id = $id;
        }

        public function setTipo($tipo) {
            $this->tipo = $tipo;
        }

        //METODOS GET
        //======================================================================
        public function getCodigo() {
            return $this->id;
        }

        public function getTipo() {
            return $this->tipo;
        }

    }
