<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_login extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        public function autenticar($idt, $senha) {

            if (!checarStatusMs(M_url_ms::sca)) {
                return M_http_code::not_found;
            }

            $sistema_id = ID_SISTEMA_SCA;

            $url = M_url_ms::sca . "/Usuarios/autenticar";

            $dados = json_encode(
                    array('identidade' => $idt,
                        'senha' => $senha,
                        'sistema_id' => $sistema_id));
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($dados))
            );

            $result = json_decode(curl_exec($ch));

            $valida = FALSE;
            if ($result->status == '1' && $result->dados !== FALSE) {
                $resp = $result->dados;
                if (isset($resp->ID) && !empty($resp->ID)) {
                    $valida = TRUE;
                }
            } else {
                $valida = FALSE;
            }
            return $valida;
        }

        public function existeUsuarioSca($idt, $senha) {
            if (!checarStatusMs(M_url_ms::sca)) {
                return M_http_code::not_found;
            }

            $url = M_url_ms::sca . "/Usuarios/existeUsuario";

            $dados = json_encode(array('identidade' => $idt,
                'senha' => $senha));
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($dados))
            );

            $result = json_decode(curl_exec($ch));
            $valida = FALSE;
            if ($result->status == '1' && $result->dados !== FALSE) {
                $resp = $result->dados;
                if (isset($resp->ID) && !empty($resp->ID)) {
                    $valida = TRUE;
                }
            } else {
                $valida = FALSE;
            }
            return $valida;
        }

        public function getPerfilUsuarioSca($idt) {
            if (!checarStatusMs(M_url_ms::sca)) {
                return M_http_code::not_found;
            }

            $sistema_id = ID_SISTEMA_SCA;
            $url = M_url_ms::sca . "/Usuarios/getPerfil";
            $valida = json_decode(file_get_contents($url));

            $dados = json_encode(array('identidade' => $idt,
                'sistema_id' => $sistema_id));
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($dados))
            );

            $result = json_decode(curl_exec($ch));

            if ($result->status == '1' && $result->dados !== FALSE) {
                $resp = $result->dados;
                if (isset($resp->ID) && !empty($resp->ID)) {
                    $valida = $resp->ID;
                }
                return $resp;
            } else {
                $valida = 0;
            }
            return $valida;
        }

        public function getUsuario($idt) {
            $sql = " select cd_usuario, nome, endereco, celular, fixo, idt from usuario where idt = ?";
            return $this->db->query($sql, array($idt))->row();
        }

    }
