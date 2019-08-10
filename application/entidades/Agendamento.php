<?php

    class Agendamento {

        //ATRIBUTOS
        //======================================================================
        private $cd_agendamento;
        private $usuario;
        private $tipo_veiculo;
        private $placa;
        private $servico;
        private $data;
        private $horario;
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
        public function setCodigo($cd_agendamento) {
            $this->cd_agendamento = $cd_agendamento;
        }

        public function setUsuario($usuario) {
            $this->usuario = $usuario;
        }

        public function setTipoVeiculo($tipo_veiculo) {
            $this->tipo_veiculo = $tipo_veiculo;
        }

        public function setPlaca($placa) {
            $this->placa = $placa;
        }

        public function setServico($servico) {
            $this->servico = $servico;
        }

        public function setData($data) {
            $this->data = $data;
        }

        public function setHorario($horario) {
            $this->horario = $horario;
        }

        public function setValor($valor) {
            $this->valor = $valor;
        }

        //METODOS GET
        //======================================================================
        public function getCodigo() {
            return $this->cd_agendamento;
        }

        public function getusuario() {
            return $this->usuario;
        }

        public function getTipoVeiculo() {
            return $this->tipo_veiculo;
        }

        public function getPlaca() {
            return $this->servico;
        }

        public function getServico() {
            return $this->servico;
        }

        public function getData() {
            return $this->data;
        }

        public function getHorario() {
            return $this->horario;
        }

        public function getValor() {
            return $this->valor;
        }

    }
