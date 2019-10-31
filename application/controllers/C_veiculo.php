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
            $dados['veiculo'] = $this->m_veiculo->getVeiculoById($id);

            if (isset($dados['veiculo']) && !empty($dados['veiculo'])) {
                $this->load->view('inc/v_inc_veiculo_editar', $dados);
            }
        }

        public function editarVeiculo() {
            $acao = $this->security->xss_clean($this->input->post('acao'));

            if (($acao !== null) && ($acao === "editar" )) {
                $veiculo = new Veiculo();
                $veiculo->setCodigo($this->security->xss_clean($this->input->post('id')));
                $veiculo->setTipo($this->security->xss_clean($this->input->post('tipo_veiculo')));

                $retorno = $this->m_veiculo->editarVeiculo($veiculo);

                if ($retorno) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                $id = $this->security->xss_clean($this->input->post('id'));
                $dados['veiculo'] = $this->m_veiculo->getVeiculoById($id);
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
                $status_ms = '';
                if (!checarStatusMs(M_url_ms::tipo_veiculo)) {
                    $status_ms = M_http_code::not_found;
                }

                $dados['titulo'] = "Cadastro de Veículo";
                $dados['status_ms'] = $status_ms;
                $this->showAjax('inc/v_inc_veiculo_adicionar', $dados);
            }
        }

        public function excluirVeiculo() {
            $id = $this->security->xss_clean($this->input->input_stream('id'));

            $retorno = $this->m_veiculo->excluirVeiculo($id);

            if ($retorno) {
                echo 1;
            } else {
                echo 0;
            }
        }

    }
