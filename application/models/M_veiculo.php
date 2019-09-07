<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_veiculo extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        public function getVeiculos() {
            $url = M_url_ms::tipo_veiculo . "/tipo_veiculos";
            return json_decode(file_get_contents($url));
        }

        public function getVeiculoById($id) {
            $url = M_url_ms::tipo_veiculo . "/tipo_veiculos/$id";
            return json_decode(file_get_contents($url));
        }

        public function editarVeiculo($veiculo) {
            $url = M_url_ms::tipo_veiculo . "/update";
            $dados = json_encode(array('id' => $veiculo->id,
                'tipo' => $veiculo->tipo));
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($dados))
            );

            $result = curl_exec($ch);
            return($result);
        }

        public function cadastrarVeiculo($tipo_veiculo) {
            $url = M_url_ms::tipo_veiculo . "/add";
            $dados = json_encode(array('tipo' => $tipo_veiculo));
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($dados))
            );

            $result = curl_exec($ch);
            return $result;
        }

        public function excluirVeiculo($id) {

            try {
                $json = '';
                $url = M_url_ms::tipo_veiculo . "/delete/$id";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result_del = curl_exec($ch);
                $result_del = json_decode($result_del);
                curl_close($ch);

                if ($result_del !== TRUE) {
                    throw new Exception("Erro ao excluir na tabela tipo_veiculo.");
                }

                $sql_tarifa = "delete from tarifa where cd_tpveiculo = ?";

                $result_tarifa = $this->db->query($sql_tarifa, $id);

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