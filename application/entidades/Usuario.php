<?php

    class Usuario {

        //ATRIBUTOS
        //======================================================================
        private $cd_usuario;
        private $nome;
        private $identidade;
        private $endereco;
        private $celular;
        private $fixo;
        private $nivel;
        private $ativo;
        private $senha;

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
        public function setCodigo($cd_usuario) {
            $this->cd_usuario = $cd_usuario;
        }

        public function setNome($nome) {
            $this->nome = $nome;
        }

        public function setIdentidade($idt) {
            $this->identidade = $idt;
        }

        public function setEndereco($end) {
            $this->endereco = $end;
        }

        public function setCelular($celular) {
            $this->celular = $celular;
        }

        public function setFixo($fixo) {
            $this->fixo = $fixo;
        }

        public function setNivel($nivel) {
            $this->nivel = $nivel;
        }

        public function setAtivo($ativo) {
            $this->ativo = $ativo;
        }

        public function setSenha($senha) {
            $this->senha = $senha;
        }

        //METODOS GET
        //======================================================================
        public function getCodigo() {
            return $this->cd_usuario;
        }

        public function getNome() {
            return $this->nome;
        }

        public function getIdentidade() {
            return $this->identidade;
        }

        public function getEndereco() {
            return $this->endereco;
        }

        public function getCelular() {
            return $this->celular;
        }

        public function getFixo() {
            return $this->fixo;
        }

        public function getNivel() {
            return $this->nivel;
        }

        public function getAtivo() {
            return $this->ativo;
        }

        public function getSenha() {
            return $this->senha;
        }

    }
