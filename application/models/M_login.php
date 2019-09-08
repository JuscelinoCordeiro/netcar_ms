<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_login extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

//    public function existeUsuario($idt, $senha) {
//        $sql = "select cd_usuario from usuario where idt = ? and senha = ?";
//        $valida = $this->db->query($sql, array($idt, $senha))->num_rows();
//        return $valida;
//    }
        public function existeUsuario($idt, $senha) {
            $url = M_url_ms::sca . "/Usuarios/existeUsuario";
            $valida = json_decode(file_get_contents($url));

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

            if ($result->status = '1') {
                $resp = $result->dados;
                if (isset($resp->ID) && !empty($resp->ID)) {
                    $valida = TRUE;
                }
            } else {
                $valida = FALSE;
            }
            return $valida;
        }

        public function getUsuario($idt) {
            $sql = " select cd_usuario, nome, endereco, celular, fixo, nivel, idt from usuario where idt = ?";
            return $this->db->query($sql, array($idt, $senha))->row();
        }

    }
