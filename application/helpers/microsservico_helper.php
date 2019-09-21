<?php

    defined('BASEPATH') OR exit('No direct script access allowed');


// ------------------------------------------------------------------------

    if (!function_exists('checarStatusMs')) {

        function checarStatusMs($url_ms) {

            @$checar_ms = fopen($url_ms, "r");

            if (@$checar_ms) {//Se verificado e existente
                return TRUE;
            } else {
                return FALSE;
            }
        }

    }



	// ------------------------------------------------------------------------
