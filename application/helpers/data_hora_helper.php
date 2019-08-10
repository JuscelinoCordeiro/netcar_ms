<?php

    defined('BASEPATH') OR exit('No direct script access allowed');



// ------------------------------------------------------------------------

    if (!function_exists('inverteData')) {

        /**
         * @param	string
         * @return	string
         */
        function inverteData($data) {
            if (count(explode("/", $data)) > 1) {
                return implode("-", array_reverse(explode("/", $data)));
            } elseif (count(explode("-", $data)) > 1) {
                return implode("/", array_reverse(explode("-", $data)));
            }
        }

    }

    if (!function_exists('horaView')) {

        /**
         * @param	string
         * @return	string
         */
        function horaView($hora) {
            return date('H:i', strtotime($hora));
        }

    }

    if (!function_exists('dataView')) {

        /**
         * @param	string
         * @return	string
         */
        function dataView($data) {
            return date('d/m/Y', strtotime($data));
        }

    }

// ------------------------------------------------------------------------
