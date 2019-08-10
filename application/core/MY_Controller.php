<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class MY_Controller extends CI_Controller {

        function __construct() {
            parent::__construct();
//        $this->isLogado();
        }

//    private static $instance;

        public function isLogado() {
            if (!$this->session->logado) {
                redirect('c_login');
            }
        }

        public function showTemplate($view = null, $dados = null) {
            $info['titulo'] = $dados['titulo'];
            $this->load->view('header', $info);
            $this->load->view('navbar');
            $this->load->view($view, $dados);
            $this->load->view('footer');
        }

        public function showAjax($view = null, $dados = null) {
            $this->load->view($view, $dados);
        }

        public function loadEntidade($classe) {
//            echo base_url('application/entidades/' . $classe);
            return require_once(APPPATH . 'entidades/' . $classe . '.php');
        }

    }
