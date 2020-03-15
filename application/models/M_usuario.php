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

        public function cadastrarUsuario($usuario) {
            if (!checarStatusMs(M_url_ms::SCA)) {
                return M_http_code::NOT_FOUND;
            }

            $this->db->trans_begin();

            $sql = "INSERT INTO usuario"
                    . "(nome, idt, endereco, celular, nivel, fixo, senha)"
                    . " VALUES (?, ?, ?, ?, ?, ?, ?)";
            $result1 = $this->db->query($sql, array($usuario->nome, $usuario->identidade, $usuario->endereco, $usuario->celular,
                $usuario->nivel, $usuario->fixo, $usuario->senha));

            if ($result1) {
                //CADASTRO NO MS-SCA
                $url = M_url_ms::SCA . "/Usuarios/cadastrarUsuario";
                $dados = json_encode(array(
                    'nome' => $usuario->nome,
                    'identidade' => $usuario->identidade,
                    'senha' => $usuario->senha,
                    'perfil' => $usuario->nivel,
                    'sistema_id' => ID_SISTEMA_SCA));
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_FAILONERROR, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($dados))
                );

                $result2 = json_decode(curl_exec($ch));
            }

            if ($result1 && $result2->dados) {
                $this->db->trans_commit();
                return TRUE;
            } else {
                $this->db->trans_rollback();
                return FALSE;
            }
        }

        public function getUsuarioById($cd_usuario) {
            $sql = "select * from usuario where cd_usuario = ?";
            return $this->db->query($sql, $cd_usuario)->row_array();
        }

        public function excluirUsuario($cd_usuario) {

            if (!checarStatusMs(M_url_ms::SCA)) {
                return M_http_code::NOT_FOUND;
            }

            $this->db->trans_begin();
            //desativar para manter o historico de agendamento, não gerar inconsistencia
            $sql = "update usuario set ativo = 0 where cd_usuario = ?";
            $result1 = $this->db->query($sql, $cd_usuario);

            //remove os perfis do usuario para esse sitema MS-SCA
            $usuario = $this->getContaUsuario($cd_usuario);

            if ($result1) {
                $url = M_url_ms::SCA . "/Usuarios/desativarUsuario";
                $dados = json_encode(array(
                    'identidade' => $usuario['idt'],
                    'sistema_id' => ID_SISTEMA_SCA));
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_FAILONERROR, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($dados))
                );

                $result2 = json_decode(curl_exec($ch));
            }

            if ($result1 && $result2->dados) {
                $this->db->trans_commit();
                return TRUE;
            } else {
                $this->db->trans_rollback();
                return FALSE;
            }
        }

        public function editarUsuario($usuario) {
            if ($usuario->nivel !== NULL) {
                if (!checarStatusMs(M_url_ms::SCA)) {
//                    return M_http_code::not_found;
                    return FALSE;
                }
                $this->db->trans_begin();

                $sql = "update usuario set nome = ?, endereco = ?, celular = ?, fixo = ?, nivel = ?, idt = ? where cd_usuario = ?";
                $result1 = $this->db->query($sql, array($usuario->nome, $usuario->endereco, $usuario->celular, $usuario->fixo,
                    $usuario->nivel, $usuario->identidade, $usuario->cd_usuario));

                if ($result1) {
                    $url = M_url_ms::SCA . "/Usuarios/editarPerfil";
                    $dados = json_encode(array(
                        'identidade' => $usuario->identidade,
                        'perfil' => $usuario->nivel,
                        'sistema_id' => ID_SISTEMA_SCA));
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_FAILONERROR, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($dados))
                    );

                    $result2 = json_decode(curl_exec($ch));
                }

                if ($result1 && $result2->dados) {
                    $this->db->trans_commit();
                    return TRUE;
                } else {
                    $this->db->trans_rollback();
                    return FALSE;
                }
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

        public function trocarSenha($cd_usuario, $senha_antiga, $senha_nova, $identidade) {
            if (!checarStatusMs(M_url_ms::SCA)) {
                return M_http_code::NOT_FOUND;
            }

            $url = M_url_ms::SCA . "/Usuarios/trocarSenha";
            $dados = json_encode(array(
                'identidade' => $identidade,
                'senha_antiga' => $senha_antiga,
                'senha' => $senha_nova));
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($dados))
            );

            $result2 = json_decode(curl_exec($ch));

            $retorno = ($result2->dados);
            return $retorno;
        }

    }
