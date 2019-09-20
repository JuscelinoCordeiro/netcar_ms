<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class M_usuario extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        public function getUsuarios() {
            $sql = "select u.cd_usuario, u.nome, u.endereco, u.celular, u.fixo, u.nivel, u.idt, up.perfil "
                    . " from usuario u"
                    . " inner join usuario_perfil up on u.nivel = up.id_perfil "
                    . " where ativo = 1"
                    . " order by u.nome";
            return $this->db->query($sql);
        }

        //SEM SENHA E COM NIVEL 0 DEFAULT (USUÁRIO)
        public function cadastrarUsuario($usuario) {
            if ($usuario->nivel !== NULL) {
                $sql = "INSERT INTO usuario"
                        . "(nome, idt, endereco, celular, nivel, fixo, senha)"
                        . " VALUES (?, ?, ?, ?, ?, ?, ?)";
                $result1 = $this->db->query($sql, array($usuario->nome, $usuario->identidade, $usuario->endereco, $usuario->celular,
                    $usuario->nivel, $usuario->fixo, $usuario->senha));

                //CADASTRO NO MS-SCA
                $url = M_url_ms::sca . "/Usuarios/cadastrarUsuario";
                $dados = json_encode(array(
                    'nome' => $usuario->nome,
                    'identidade' => $usuario->identidade,
                    'senha' => $usuario->senha,
                    'perfil' => $usuario->nivel));
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_FAILONERROR, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($dados))
                );

                $result2 = curl_exec($ch);


                $result2 = json_decode(curl_exec($ch));
                print_r($result2);
//                return ($result1 && $result2->status);
//                if ($result->status = '1') {
//                    $resp = $result->dados;
//                    if (isset($resp->ID) && !empty($resp->ID)) {
//                        $valida = TRUE;
//                    }
//                } else {
//                    $valida = FALSE;
//                }
//                return $valida;
            } else {
                $sql = "INSERT INTO usuario"
                        . "(nome, idt, endereco, celular, fixo, nivel, senha)"
                        . " VALUES (?, ?, ?, ?, ?, ?, ?)";
                return $this->db->query($sql, array($usuario->nome, $usuario->identidade, $usuario->endereco, $usuario->celular,
                            $usuario->fixo, 10, $usuario->senha));
            }
        }

        public function getUsuarioById($cd_usuario) {
            $sql = "select * from usuario where cd_usuario = ?";
            return $this->db->query($sql, $cd_usuario)->row_array();
        }

        public function excluirUsuario($cd_usuario) {
//        $sql = "delete from usuario where cd_usuario = ?";
            //desativar para manter o historico de agendamento, não gera inconsistencia
            $sql = "update usuario set ativo = 0 where cd_usuario = ?";
            return $this->db->query($sql, $cd_usuario);
        }

        public function editarUsuario($usuario) {
            if ($usuario->nivel !== NULL) {
                $sql = "update usuario set nome = ?, endereco = ?, celular = ?, fixo = ?, nivel = ?, idt = ? where cd_usuario = ?";
                return $this->db->query($sql, array($usuario->nome, $usuario->endereco, $usuario->celular, $usuario->fixo,
                            $usuario->nivel, $usuario->identidade, $usuario->cd_usuario));
            } else {
                $sql = "update usuario set nome = ?, endereco = ?, celular = ?, fixo = ?, idt = ? where cd_usuario = ?";
                return $this->db->query($sql, array($usuario->nome, $usuario->endereco, $usuario->celular, $usuario->fixo,
                            $usuario->identidade, $usuario->cd_usuario));
            }
        }

        public function atualizarContaUsuario($usuario) {
            $sql = "update usuario set nome = ?, endereco = ?, celular = ?, fixo = ?, idt = ? where cd_usuario = ?";
            return $this->db->query($sql, array($usuario->nome, $usuario->endereco, $usuario->celular, $usuario->fixo,
                        $usuario->identidade, $usuario->cd_usuario));
        }

        public function existeUsuario($idt) {
            $sql = "select cd_usuario from usuario where idt = ?";
            return $this->db->query($sql, array($idt));
        }

        public function getContaUsuario($cd_usuario) {
            $sql = "select cd_usuario, nome, idt, endereco, celular, nivel, fixo from usuario where cd_usuario = ?";
            return $this->db->query($sql, $cd_usuario)->row_array();
        }

        public function trocarSenha($cd_usuario, $senha_antiga, $senha_nova) {
            $sql = "update usuario set senha = ? where cd_usuario = ? and senha = ?";
            return $this->db->query($sql, array($senha_nova, $cd_usuario, $senha_antiga));
        }

    }
