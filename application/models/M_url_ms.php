<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_url_ms extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        //constantes de url microsserviços
        const tipo_veiculo = 'http://127.0.0.1:5000';
        const sca = 'http://127.0.0.1:8001';
//        const sca = 'http://127.0.0.1:8002';
//        const sca = 'http://127.0.0.1/ms-sca';
        const pdf = 'http://127.0.0.1:8003';

    }
    