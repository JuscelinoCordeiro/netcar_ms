<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_tarifa extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        public function cadastrarTarifa($cd_tpveiculo, $cd_servico) {
            $sql = "insert into tarifa (cd_tpveiculo, cd_servico) values (?, ?)";

            return $this->db->query($sql, array($cd_tpveiculo, $cd_servico));
        }

        public function getTarifas() {
            $sql = "SELECT t.*, s.servico
                FROM tarifa t
                INNER JOIN servico s
                ON t.cd_servico = s.cd_servico
                where s.ativo = 1
                ORDER BY t.cd_servico";
            return $this->db->query($sql);
        }

        public function getTarifaServico($cd_servico) {
            $sql = "SELECT *
                FROM tarifa
                where cd_servico = ?";

            return $this->db->query($sql, $cd_servico);
        }

        public function getTarifaServicoTpVeiculo($tarifa) {
            $sql = "SELECT preco
                FROM tarifa
                where cd_servico = ? and cd_tpveiculo = ?";

            return $this->db->query($sql, array($tarifa->servico, $tarifa->tipo_veiculo));
        }

        public function getValor($servico, $cd_tpveiculo) {
            $sql = "SELECT preco
                FROM tarifa
                where cd_servico = ? and cd_tpveiculo = ?";

            return $this->db->query($sql, array($servico, $cd_tpveiculo))->row();
        }

        public function editarTarifa($tarifa) {
            $sql = "UPDATE tarifa SET preco = ?
                where cd_servico = ? and cd_tpveiculo = ?";

            return $this->db->query($sql, array($tarifa->preco, (int) $tarifa->servico, (int) $tarifa->tipo_veiculo));
        }

        public function excluirTarifa($cd_servico) {
            $sql = "delete from tarifa where cd_servico = ?";

            return $this->db->query($sql, $cd_servico);
        }

        public function excluirTarifaTpVeiculo($cd_tpveiculo, $cd_servico) {
            $sql = "delete from tarifa where cd_tpveiculo = ? and cd_servico = ?";

            return $this->db->query($sql, array($cd_tpveiculo, $cd_servico));
        }

    }
