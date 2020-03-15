<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_http_code extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        //constantes de erros http
        const SUCESS = '200';
        const MOVED_PERMANENTLY = '301';
        const BAD_REQUEST = '400';
        const UNAUTHORIZED = '401';
        const FORBIDDEN = '403';
        const NOT_FOUND = '404';
        const INTERNAL_SERVER_ERROR = '500';

    }
