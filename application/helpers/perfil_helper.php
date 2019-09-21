<?php

    defined('BASEPATH') OR exit('No direct script access allowed');


// ------------------------------------------------------------------------

    if (!function_exists('validaPerfil')) {

        function validaPerfil($array_perfis, $perfil_usuario) {
            if (in_array($perfil_usuario, $array_perfis)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

    }

    if (!function_exists('nomePerfil')) {

        function nomePerfil($codPerfil) {
            $perfis = array(10 => 'Cliente', 1 => 'Operador', 2 => 'Financeiro', 3 => 'Gerente');
//			$perfis = array('C', 'O', 'F', 'G');
            return $perfis[$codPerfil];
        }

    }

	// ------------------------------------------------------------------------
