<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class C_inicio extends MY_Controller {

        function __construct() {
            parent::__construct();
            $this->isLogado();
        }

        public function index() {

            $info['titulo'] = "NetCar - Home";
            $this->showTemplate('v_inicio', $info);
        }

    }
