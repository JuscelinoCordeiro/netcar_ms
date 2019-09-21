<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_http_code extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        //constantes de erros http
        const sucess = '200';
        const moved_permanently = '301';
        const bad_request = '400';
        const unauthorized = '401';
        const forbidden = '403';
        const not_found = '404';
        const internal_server_error = '500';

    }
