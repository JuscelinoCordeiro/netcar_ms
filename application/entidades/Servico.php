<?php

    class Servico {

        //ATRIBUTOS
        //======================================================================
        private $cd_servico;
        private $servico;
        private $ativo;

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
        public function setCodigo($cd_servico) {
            $this->cd_servico = $cd_servico;
        }

        public function setServico($servico) {
            $this->servico = $servico;
        }

        public function setAtivo($ativo) {
            $this->ativo = $ativo;
        }

        //METODOS GET
        //======================================================================
        public function getCodigo() {
            return $this->cd_servico;
        }

        public function getServico() {
            return $this->servico;
        }

        public function getAtivo() {
            return $this->ativo;
        }

    }
