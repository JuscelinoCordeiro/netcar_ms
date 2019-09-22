<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class C_servico extends MY_Controller {

        function __construct() {
            parent::__construct();
            $this->isLogado();
            $this->load->model('m_servico');
            $this->loadEntidade('Servico');
        }

        public function index() {

            $info['titulo'] = "Serviços";
            $dados['servicos'] = $this->m_servico->getservicos();
            $this->load->view('header', $info);
            $this->load->view('navbar');
            $this->load->view('v_servico', $dados);
            $this->load->view('footer');
        }

        public function getServicoById() {
            $dados['servico'] = $this->m_servico->getservicoById($cd_servico);

            if (isset($dados['servico']) && !empty($dados['servico'])) {
                $this->load->view('inc/v_inc_servico_editar', $dados);
            }
        }

        public function editarServico() {
            $acao = $this->security->xss_clean($this->input->post('acao'));

            if (($acao !== null) && ($acao === "editar" )) {
                $cd_servico = $this->input->post('cd_servico');
                $servico = $this->input->post('servico');
                $tipo_veiculos = $this->input->post('tipo_veiculos');

                //editar
                $retorno = $this->m_servico->editarServico($cd_servico, $servico, $tipo_veiculos);



                if ($retorno) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                $this->load->model('m_veiculo');
                $this->load->model('m_tarifa');

                $cd_servico = $this->security->xss_clean($this->input->post('cd_servico'));
                $dados['servico'] = $this->m_servico->getServicoById($cd_servico)->row();
                $dados['tipo_veiculos'] = $this->m_veiculo->getVeiculos();
                $dados['tarifas'] = $this->m_tarifa->getTarifaServico($cd_servico)->result();

                $dados['titulo'] = "Edição de Serviço";
                $this->showAjax('inc/v_inc_servico_editar', $dados);
            }
        }

        public function cadastrarServico() {
            $acao = $this->security->xss_clean($this->input->post('acao'));

            if (($acao !== null) && ($acao === "cadastrar" )) {
                $servico = $this->security->xss_clean($this->input->post('servico'));
                $tipo_veiculos = $this->security->xss_clean($this->input->post('tipo_veiculos'));

                $retorno = $this->m_servico->cadastrarServico($servico, $tipo_veiculos);

                if ($retorno) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                $this->load->model('m_veiculo');
                $dados['tipo_veiculos'] = $this->m_veiculo->getVeiculos();
                $dados['titulo'] = "Cadastro de Serviço";
                $this->showAjax('inc/v_inc_servico_adicionar', $dados);
            }
        }

        public function excluirServico() {
            $this->load->model('m_tarifa');
            $cd_servico = $this->security->xss_clean($this->input->post('cd_servico'));

            //excluindo o serviço
            $retorno1 = $this->m_servico->excluirServico($cd_servico);

            //excluindo as tarifas do serviço caso existam
            $retorno2 = TRUE;
            $tarifas = $this->m_tarifa->getTarifaServico($cd_servico);
            if ($tarifas->num_rows() > 0) {
                $retorno2 = $this->m_tarifa->excluirTarifa($cd_servico);
            }

            if ($retorno1 && $retorno2) {
                echo 1;
            } else {
                echo 0;
            }
        }

        public function mudarStatus() {
            $cd_servico = $this->security->xss_clean($this->input->post('cd_servico'));
            $status = $this->security->xss_clean($this->input->post('status'));

            $retorno = $this->m_servico->mudarStatus($cd_servico, $status);

            if ($retorno) {
                echo 1;
            } else {
                echo 0;
            }
        }

        public function comboServicos() {
            $cd_tpVeiculo = $this->security->xss_clean($this->input->post('cd_tpveiculo'));

            if ($cd_tpVeiculo == '-1') {
                $servicos = $this->m_servico->getServicos()->result();
            } else {
                $servicos = $this->m_servico->getServicosTpVeiculos($cd_tpVeiculo)->result();
            }

            $servico = "<option value=\"\">Selecione um serviço</option>";
            foreach ($servicos as $sv) {
                $servico .= '<option value="' . $sv->cd_servico . '">' . $sv->servico . '</option>';
            }

            echo $servico;
        }

    }
