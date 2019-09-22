<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class C_faturamento extends MY_Controller {

        function __construct() {
            parent::__construct();
            $this->isLogado();
            $this->load->model('m_faturamento');
            $this->load->model('m_veiculo');
        }

        public function listarFaturamentoDiario() {
            //a variavel faturamento recebe um array contendo um arraylist de objetos de faturamento e
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

    }
