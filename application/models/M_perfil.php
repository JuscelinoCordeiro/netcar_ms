<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_perfil extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        const Cliente = 0;
        const Operador = 1;
        const Financeiro = 2;
        const Gerente = 3;

    }
