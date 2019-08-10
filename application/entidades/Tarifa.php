<?php

    class Tarifa {

        //ATRIBUTOS
        //======================================================================
        private $cd_tarifa;
        private $tipo_veiculo;
        private $servico;
        private $preco;

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
        public function setCodigo($cd_tarifa) {
            $this->cd_tarifa = $cd_tarifa;
        }

        public function setTipoVeiculo($tipo_veiculo) {
            $this->tipo_veiculo = $tipo_veiculo;
        }

        public function setServico($servico) {
            $this->servico = $servico;
        }

        public function setPreco($preco) {
            $this->preco = $preco;
        }

        //METODOS GET
        //======================================================================
        public function getCodigo() {
            return $this->cd_tarifa;
        }

        public function getTipoVeiculo() {
            return $this->tipo_veiculo;
        }

        public function getServico() {
            return $this->servico;
        }

        public function getPreco() {
            return $this->preco;
        }

    }
