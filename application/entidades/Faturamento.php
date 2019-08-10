<?php

    class Faturamento {

        //ATRIBUTOS
        //======================================================================
        private $cd_faturamento;
        private $data;
        private $horario;
        private $servico;
        private $tipo_veiculo;
        private $valor;

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
        public function setCodigo($cd_faturamento) {
            $this->cd_faturamento = $cd_faturamento;
        }

        public function setData($data) {
            $this->data = $data;
        }

        public function setHorario($horario) {
            $this->horario = $horario;
        }

        public function setServico($servico) {
            $this->servico = $servico;
        }

        public function setTipoVeiculo($tipo_veiculo) {
            $this->tipo_veiculo = $tipo_veiculo;
        }

        public function setValor($valor) {
            $this->valor = $valor;
        }

        //METODOS GET
        //======================================================================
        public function getCodigo() {
            return $this->cd_faturamento;
        }

        public function getData() {
            return $this->data;
        }

        public function getHorario() {
            return $this->horario;
        }

        public function getServico() {
            return $this->servico;
        }

        public function getTipoVeiculo() {
            return $this->tipo_veiculo;
        }

        public function getValor() {
            return $this->valor;
        }

    }
