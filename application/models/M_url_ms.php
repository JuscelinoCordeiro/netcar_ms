<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_url_ms extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        //constantes de url microsserviços
        const TIPO_VEICULO = 'http://10.7.75.9:8080';
        const SCA = 'http://127.0.0.1:8001';
        const PDF = 'http://127.0.0.1:8003';

    }
