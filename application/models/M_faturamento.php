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
            if (!checarStatusMs(M_url_ms::pdf)) {
                return M_http_code::not_found;
            }

            $url = M_url_ms::pdf . "/index.php";
            $dados = '<div align="center"><img align="center" height="90px" src="' . base_url('assets/img/carwash.jpg') . '"/></div>';
            $dados .= '<h3 align="center">NetCAR - Serviços de Limpeza Automotiva</h3><br>';
            $dados .= '<h3>Comprovante de Execução de Serviço</h3>';
            $dados .= '<table border="1"  cellspacing="0"cellpadding="2" class="table table-bordered table-condensed" style="text-align: center">';
            $dados .= '<thead>';
            $dados .= '<tr>';
            $dados .= '<th>Código</th>';
            $dados .= '<th>Data</th>';
            $dados .= '<th>Horário</th>';
            $dados .= '<th>Serviço</th>';
            $dados .= '<th>Tipo de Veículo</th>';
            $dados .= '<th>Valor</th>';
            $dados .= '</tr>';
            $dados .= '</thead>';
            $dados .= '<tbody>';
            $dados .= '<tr>';
            $dados .= '<td>' . $faturamento->getCodigo() . '</td>';
            $dados .= '<td>' . date('d/m/Y', strtotime($faturamento->getData())) . '</td>';
            $dados .= '<td>' . date('H:i', strtotime($faturamento->getHorario())) . '</td>';
            $dados .= '<td>' . $faturamento->getServico() . '</td>';
            $dados .= '<td>' . $faturamento->getTipoVeiculo() . '</td>';
            $dados .= '<td>' . $faturamento->getValor() . '</td>';
            $dados .= '</tbody>';
            $dados .= '</table>';

//            $usuario = $this->session->userdata('dados_usuario');
//            $rodape = "Impresso por: " . utf8_encode($usuario->nome) . "  - Identidade: $usuario->idt | {DATE d/m/y H:i}|{PAGENO}/{nb}";
            $rodape = '';
            $dados .= '<br><br>' . $rodape;

            $dados = json_encode(array('conteudo' => $dados));
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
//            print_r($result);
//            die();
            return $result;
        }

        public function imprimirFaturamento($dados) {
            //verifica se o microserviço esta ativo
            if (!checarStatusMs(M_url_ms::pdf)) {
                return M_http_code::not_found;
            }

            $url = M_url_ms::pdf . "/index.php";

            $dados = json_encode(array('conteudo' => $dados));
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
