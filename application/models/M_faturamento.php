<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class M_faturamento extends CI_Model {

        public function listarFaturamentoDiario() {
            $dataHoje = date("Y-m-d");

            $sql = "select f.*, s.servico "
                    . " from faturamento as f "
                    . " inner JOIN servico as s on f.cd_servico = s.cd_servico"
                    . " where f.data = ?"
                    . " order by f.data asc , f.horario asc";




//            print_r($faturamento);
            $total = "select sum(valor) as total from faturamento where data = ?";

            //pega um arraylist de objetos de faturamentos
            $dados['faturamento'] = $this->db->query($sql, $dataHoje)->result();
            //pega a soma dos valores faturados
            $dados['total'] = $this->db->query($total, $dataHoje)->row()->total;

            return $dados;
        }

        public function listarFaturamentoPeriodo($dt_inicio, $dt_fim) {
            $faturamento = "select f.*, s.servico "
                    . " from faturamento as f "
                    . " inner JOIN servico as s on f.cd_servico = s.cd_servico"
                    . " where f.data between ? and ? "
                    . " order by f.data asc , f.horario asc";

            $total = "select sum(valor) as total from faturamento where data between ? and ? ;";

            //pega um arraylist de objetos de faturamentos
            $dados['faturamento'] = $this->db->query($faturamento, array($dt_inicio, $dt_fim))->result();

            //pega a soma dos valores faturados
            $dados['total'] = $this->db->query($total, array($dt_inicio, $dt_fim))->row()->total;

            return $dados;
        }

        public function setFaturamento($agendamento) {
            $sql = $sql = "insert into faturamento (cd_tpveiculo, cd_servico, data, horario, valor)"
                    . " values (?, ?, ?, ?,? )";

            return $this->db->query($sql, array((int) $agendamento->cd_tpveiculo, (int) $agendamento->cd_servico, $agendamento->data, $agendamento->horario, floatval($agendamento->preco)));
        }

        public function getFaturamento($cd_fatura) {
            $sql = " select * from faturamento where cd_fatura = ?";

            return $this->db->query($sql, $cd_fatura);
        }

        public function gerarComprovante($faturamento) {
            //verifica se o microserviço esta ativo
            if (!checarStatusMs(M_url_ms::comprovante)) {
                return M_http_code::not_found;
            }

            $url = M_url_ms::comprovante . "caminho";

            $dados = json_encode(array(
                'codigo' => $faturamento->getCodigo(),
                'data' => $faturamento->getData(),
                'horario' => $faturamento->getHorario(),
                'servico' => $faturamento->getServico(),
                'tipo_veiculo' => $faturamento->getTipoVeiculo(),
                'valor' => $faturamento->getValor(),
            ));
            echo '<pre>';
            print_r($dados);
            die();
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

    }
