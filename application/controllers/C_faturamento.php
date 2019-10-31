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

        public function gerarComprovante() {
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



            $retorno = json_decode($this->m_faturamento->gerarComprovante($faturamento));
//            $retorno = '404';
//            $retorno->status = 0;
//            $retorno->dados = '';
            if ($retorno == M_http_code::not_found) {
                $msg['msg'] = 'Serviço Indisponível. Tente mais tarde.';
                $this->load->view('errors/v_erro', $msg);
            } else {
                if (($retorno->status == '1') && $retorno->dados != 'erro') {
                    $arquivo['arquivo'] = 'http://127.0.0.1/ms-relatorio' . $retorno->dados;
                    $this->load->view('v_relatorio_pdf', $arquivo);
                } else {
                    $msg['msg'] = 'ERRO! Não foi possivel gerar o arquivo.';
                    $this->load->view('errors/v_erro', $msg);
                }
            }
        }

        public function imprimirFaturamento() {
            $hora_relatorio = date("d/m/Y H:i:s");
            $titulo = strtoupper($this->security->xss_clean($this->input->post('titulo')));
//            $dados = '<div align="center"><img align="center" height="90px" src="' . base_url('assets/img/carwash.jpg') . '"/></div>';
            $dados = '<div align="center"><img align="center" height="90px" src="http://172.23.0.1/netcar/assets/img/carwash.jpg"/></div>';
            $dados .= '<h3 align="center">NetCAR - Serviços de Limpeza Automotiva</h3><br>';
            $dados .= '<h3>' . $titulo . '</h3>';
            $dados .= '<table border="1" cellspacing="0"cellpadding="2" class="table table-bordered table-condensed"  style="text-align: center">';
            $dados .= $this->security->xss_clean($this->input->post('conteudo'));
            $dados .= '</table>';

            $usuario = $this->session->userdata('dados_usuario');
            $rodape = "Impresso por: " . utf8_encode($usuario->nome) . "  - Identidade: $usuario->idt em " . $hora_relatorio;
            $dados .= '<br><br>' . $rodape;

            $retorno = json_decode($this->m_faturamento->imprimirFaturamento($dados));

//            $retorno = '404';
//            $retorno->status = 0;
//            $retorno->dados = '';
            if ($retorno == M_http_code::not_found) {
                $msg['msg'] = 'Serviço Indisponível. Tente mais tarde.';
                $this->load->view('errors/v_erro', $msg);
            } else {
                if (($retorno->status == '1') && $retorno->dados != 'erro') {
                    $arquivo['arquivo'] = M_url_ms::pdf . '/' . $retorno->dados;
                    $this->load->view('v_relatorio_pdf', $arquivo);
                } else {
                    $msg['msg'] = 'ERRO! Não foi possivel gerar o arquivo.';
                    $this->load->view('errors/v_erro', $msg);
                }
            }
        }

    }
