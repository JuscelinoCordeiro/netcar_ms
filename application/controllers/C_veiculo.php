<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class C_veiculo extends MY_Controller {

        function __construct() {
            parent::__construct();
            $this->isLogado();
            $this->load->model('m_veiculo');
            $this->loadEntidade('Veiculo');
        }

        public function index() {

            $info['titulo'] = "Veículos";
            $dados['veiculos'] = $this->m_veiculo->getVeiculos();
            $this->load->view('header', $info);
            $this->load->view('navbar');
            $this->load->view('v_veiculo', $dados);
            $this->load->view('footer');
        }

        public function getVeiculoById() {
            $dados['veiculo'] = $this->m_veiculo->getVeiculoById($cd_tpveiculo);

            if (isset($dados['veiculo']) && !empty($dados['veiculo'])) {
                $this->load->view('inc/v_inc_veiculo_editar', $dados);
            }
        }

        public function editarVeiculo() {
            $acao = $this->security->xss_clean($this->input->post('acao'));

            if (($acao !== null) && ($acao === "editar" )) {
                $veiculo = new Veiculo();
                $veiculo->setCodigo($this->security->xss_clean($this->input->post('cd_tpveiculo')));
                $veiculo->setTipo($this->security->xss_clean($this->input->post('tipo_veiculo')));

                $retorno = $this->m_veiculo->editarVeiculo($veiculo);

                if ($retorno) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                $cd_tpveiculo = $this->security->xss_clean($this->input->post('cd_tpveiculo'));
                $dados['veiculo'] = $this->m_veiculo->getVeiculoById($cd_tpveiculo)->row();
                $dados['titulo'] = "Editar Veículo";
                $this->showAjax('inc/v_inc_veiculo_editar', $dados);
            }
        }

        public function cadastrarVeiculo() {
            $acao = $this->security->xss_clean($this->input->post('acao'));

            if (($acao !== null) && ($acao === "cadastrar" )) {
                $tipo_veiculo = $this->security->xss_clean($this->input->post('tipo_veiculo'));

                $retorno = $this->m_veiculo->cadastrarVeiculo($tipo_veiculo);

                if ($retorno) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                $dados['titulo'] = "Cadastro de Veículo";
                $this->showAjax('inc/v_inc_veiculo_adicionar');
            }
        }

        public function excluirVeiculo() {
            $cd_tpveiculo = $this->security->xss_clean($this->input->post('cd_tpveiculo'));

            $retorno = $this->m_veiculo->excluirVeiculo($cd_tpveiculo);

            if ($retorno) {
                echo 1;
            } else {
                echo 0;
            }
        }

    }
