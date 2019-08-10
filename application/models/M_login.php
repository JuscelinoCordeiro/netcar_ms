<?php

if (!defined('BASEPATH'))
    exit('No	direct script access allowed');

class M_login extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function existeUsuario($idt, $senha) {
        $sql = "select cd_usuario from usuario where idt = ? and senha = ?";
        $valida = $this->db->query($sql, array($idt, $senha))->num_rows();
        return $valida;
    }

    public function getUsuario($idt, $senha) {
        $sql = " select cd_usuario, nome, endereco, celular, fixo, nivel, idt from usuario where idt = ? and senha = ?";
        return $this->db->query($sql, array($idt, $senha))->row();
    }

}
