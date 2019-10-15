<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class C_login extends MY_Controller {

        function __construct() {
            parent::__construct();
            $this->load->model('m_login');
            $this->load->model('m_usuario');
            $this->loadEntidade('Usuario');
        }

        public function index($info = null) {

            if (!checarStatusMs(M_url_ms::sca)) {
                $info['mensagem'] = 'SERVIÇO DE AUTENTICAÇÃO INDISPONÍVEL';
            }

            $info['titulo'] = "NetCar - Login";
            $this->load->view('header', $info);
            $this->load->view('v_login');
            $this->load->view('footer');
        }

        public function logar() {
            if (!checarStatusMs(M_url_ms::sca)) {
                redirect('c_inicio/index');
            }

            if (($this->session->userdata('logado') === TRUE)) {
                redirect('c_inicio/index');
            } else {
                $idt = $this->security->xss_clean($this->input->post('idt'));
                $senha = $this->security->xss_clean($this->input->post('senha'));
                $acao = $this->security->xss_clean($this->input->post('acao'));

                if (isset($acao) && $acao === 'logar') {
                    if ((isset($idt) && !empty($idt)) && (isset($senha) && !empty($senha))) {

                        $senha = sha1($senha);
                        //verifica se existe o usuario
                        $existeUsuario = $this->m_usuario->existeUsuario($idt)->row();

                        if (isset($existeUsuario) && !empty($existeUsuario)) {
                            //verifica se existe o usuario, autenticando no ms-sca
                            $existeUsuarioSca = $this->m_login->existeUsuarioSca($idt, $senha);

                            if ($existeUsuarioSca) {

                                //verifica no ms-sca se o usuario tem autorizaçao de acesso ao sistema
                                $valida = $this->m_login->autenticar($idt, $senha);

                                if ($valida) {

                                    //pega o objeto com os dados do usuário
                                    $usuario = $this->m_login->getUsuario($idt, $senha);

                                    //pega o perfil do usuario no SCA
                                    $perfil = $this->m_login->getPerfilUsuarioSca($idt);
                                    if (!isset($usuario->nivel) || empty($usuario->nivel)) {
                                        $usuario->nivel = $perfil->ID;
                                    }
                                    $this->session->set_userdata('dados_usuario', $usuario);
                                    $this->session->set_userdata('logado', TRUE);
                                    $dados['titulo'] = "NetCar - Home";
                                    $this->showTemplate('v_inicio', $dados);
                                } else {
                                    $info['mensagem'] = "USUÁRIO SEM AUTORIZAÇÃO DE ACESSO";
                                    $this->index($info);
                                }
                            } else {
                                $info['mensagem'] = "USUÁRIO E/OU SENHA INVÁLIDO";
                                $this->index($info);
                            }
                        } else {
                            $info['mensagem'] = "USUÁRIO INEXISTENTE";
                            $this->index($info);
                        }
                    } else {
                        $info['mensagem'] = "USUÁRIO E/OU SENHA INVÁLIDO";
                        $this->index($info);
                    }
                }
            }
        }

        public function logout() {
            $this->session->sess_destroy();
            redirect('c_login');
        }

    }
