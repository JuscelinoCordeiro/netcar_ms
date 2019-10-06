<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class C_faturamento extends MY_Controller {

        function __construct() {
            parent::__construct();
            $this->isLogado();
            $this->load->model('m_faturamento');
            $this->load->model('m_veiculo');
            $this->load->model('m_servico');
            $this->loadEntidade('Faturamento');
        }

        public function listarFaturamentoDiario() {
            // a variavel faturamento recebe um array contendo um arraylist de objetos de faturamento e
            // a soma dos faturamentos
            $faturamento = $this->m_faturamento->listarFaturamentoDiario();

            //PEGANDO O TIPO DE VEICULO DO MICROSSERVIÇO
            $fatura = $faturamento['faturamento'];
            foreach ($fatura as &$f) {
                $tipo_veiculo = $this->m_veiculo->getVeiculoById($f->cd_tpveiculo);
                $f->tipo = ($tipo_veiculo != M_http_code::not_found) ? $tipo_veiculo->tipo : 'Sem Informação';
            }


            $dados['titulo'] = "Faturamento Diário";
            $dados['faturamento'] = $fatura;
            $dados['total'] = $faturamento['total'];

            $this->showTemplate('v_faturamento_diario', $dados);
        }

        public function listarFaturamentoPeriodo() {
            $acao = $this->security->xss_clean($this->input->post('acao'));
            if (($acao !== null) && ($acao === "pesquisar" )) {
                $dt_ini = inverteData($this->security->xss_clean($this->input->post('dt_inicio')));
                $dt_fim = inverteData($this->security->xss_clean($this->input->post('dt_fim')));

                //a variavel faturamento recebe um array contendo um arraylist de objetos de faturamento e
                // a soma dos faturamentos
                $faturamento = $this->m_faturamento->listarFaturamentoPeriodo($dt_ini, $dt_fim);

                //PEGANDO O TIPO DE VEICULO DO MICROSSERVIÇO
                $fatura = $faturamento['faturamento'];
                foreach ($fatura as &$f) {
                    $tipo_veiculo = $this->m_veiculo->getVeiculoById($f->cd_tpveiculo);
                    $f->tipo = ($tipo_veiculo != M_http_code::not_found) ? $tipo_veiculo->tipo : 'Sem Informação';
                }


                $dados['titulo'] = "Faturamentos";
                $dados['faturamento'] = $fatura;
                $dados['total'] = $faturamento['total'];
                $dados['dt_inicio'] = $dt_ini;
                $dados['dt_fim'] = $dt_fim;

                $this->showAjax("v_faturamento_periodo", $dados);
            } else {
                $this->showAjax('inc/v_inc_faturamento_pesquisar');
            }
        }

        public function imprimirFatura() {
            $cd_fatura = $this->security->xss_clean($this->input->post('cd_fatura'));

            $fatura = $this->m_faturamento->getFaturamento($cd_fatura)->row();
//
            $faturamento = new Faturamento();
            $faturamento->setCodigo($fatura->cd_fatura);
            $faturamento->setData($fatura->data);
            $faturamento->setHorario($fatura->horario);

            $servico = $this->m_servico->getServicoById($fatura->cd_servico)->row()->servico;
            $faturamento->setServico($servico);

            $tipo_veiculo = $this->m_veiculo->getVeiculoById($fatura->cd_tpveiculo);
            $faturamento->setTipoVeiculo(($tipo_veiculo !== M_http_code::not_found) ? $tipo_veiculo->tipo : "Não discriminado.");
            $faturamento->setValor('R$ ' . $fatura->valor . ',00');


            $retorno = $this->m_faturamento->gerarComprovante($faturamento);
//            print_r($fatura);
            echo '<pre>';
            print_r($faturamento);
            die();
        }

        public function gerarComprovante() {
//            $cd_fatura = $this->security->xss_clean($this->input->post('cd_fatura'));
            $dados = $this->security->xss_clean($this->input->post('conteudo'));
//            print_r($dados);
//            die();
            $url = 'http://127.0.0.1/mpdf/index.php';
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
            echo $result;
//            echo '<pre>';
////            print_r($conteudo);
//            die();
        }

        public function imprimirFaturamento() {
//            $cd_fatura = $this->security->xss_clean($this->input->post('cd_fatura'));
            $dados = '<table>';
            $dados .= $this->security->xss_clean($this->input->post('conteudo'));
            $dados .= '</table>';
//            print_r($dados);
//            die();

            $url = 'http://127.0.0.1/ms-pdf/index.php';
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

            echo curl_exec($ch);
            $result = curl_exec($ch);
//            return $result;
        }

    }
