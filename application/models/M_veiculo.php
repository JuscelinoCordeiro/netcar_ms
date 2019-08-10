<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_veiculo extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        public function getVeiculos() {
            $sql = "select * from tipo_veiculo";
            return $this->db->query($sql);
        }

        public function getVeiculoById($cd_tpveiculo) {
            $sql = "select * from tipo_veiculo where cd_tpveiculo = ?";
            return $this->db->query($sql, $cd_tpveiculo);
        }

        public function editarVeiculo($veiculo) {
            $sql = "UPDATE tipo_veiculo SET tipo = ? WHERE cd_tpveiculo = ?";
            return $this->db->query($sql, array($veiculo->tipo, $veiculo->cd_tpveiculo));
        }

        public function cadastrarVeiculo($tipo_veiculo) {
            $sql = "INSERT INTO tipo_veiculo (tipo) VALUES (?)";
            return $this->db->query($sql, $tipo_veiculo);
        }

        public function excluirVeiculo($cd_tpveiculo) {
            try {
                $sql_del = "delete from tipo_veiculo where cd_tpveiculo = ?";
                $result_del = $this->db->query($sql_del, $cd_tpveiculo);

                if ($result_del === FALSE) {
                    throw new Exception("Erro ao excluir na tabela tipo_veiculo.");
                }

                $sql_tarifa = "delete from tarifa where cd_tpveiculo = ?";

                $result_tarifa = $this->db->query($sql_tarifa, $cd_tpveiculo);

                if ($result_tarifa === FALSE) {
                    throw new Exception("Erro ao excluir na tabela tarifa.");
                }

                //verifica se houve erros
                if ($result_del === TRUE && $result_tarifa == TRUE) {
                    return 1;
                } else {
                    return 0;
                }
            } catch (Exception $ex) {
                return 0;
            }
        }

    }
