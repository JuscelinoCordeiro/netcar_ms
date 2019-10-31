<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_agendamento extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        public function verificarAgendamentoIncompleto($data = null, $data_fim = null, $cd_agend = null) {
            if (!empty($data) && empty($data_fim)) {
                $sql = "select * from agendamento where data = ?";
                $result = $this->db->query($sql, $data);
            } elseif (!empty($data) && !empty($data_fim)) {
                $sql = "select * from agendamento where data between ? and ? ";
                $result = $this->db->query($sql, array($data, $data_fim));
            } else {
                $sql = "select * from agendamento where cd_agendamento = ?";
                $result = $this->db->query($sql, $cd_agend);
            }



            foreach ($result->result() as $ag) {
                if ($ag->cd_tpveiculo == NULL) {
                    return TRUE;
                }
            }
            return FALSE;
        }

        public function getAgendamentosDoDia($dtHoje, $cd_usuario = null) {
            if ($cd_usuario) {
                $usuario = "and ag.cd_usuario = $cd_usuario";
            } else {
                $usuario = "";
            }
//            if (checarStatusMs(M_url_ms::tipo_veiculo) && !($this->verificarAgendamentoIncompleto($dtHoje))) {
//                $sql = "select ag.*, user.nome, tp.*, sv.*, ta.preco "
//                        . "from agendamento as ag inner join usuario as user on ag.cd_usuario = user.cd_usuario "
//                        . "inner join tipo_veiculo as tp on tp.cd_tpveiculo = ag.cd_tpveiculo "
//                        . "inner join servico as sv on ag.cd_servico = sv.cd_servico "
//                        . "inner join tarifa as ta on tp.cd_tpveiculo = ta.cd_tpveiculo and sv.cd_servico = ta.cd_servico "
//                        . "where data = ? "
//                        . $usuario
//                        . " order by horario asc";
//            } else {
            $sql = "select ag.*, user.nome, sv.*"
                    . "from agendamento as ag inner join usuario as user on ag.cd_usuario = user.cd_usuario "
                    . "inner join servico as sv on ag.cd_servico = sv.cd_servico "
                    . "where data = ? "
                    . $usuario
                    . " order by horario asc";
//            }

            return $this->db->query($sql, $dtHoje);
        }

        public function getAgendamentoByData($dt_ini, $dt_fim, $cd_usuario = null) {
            if ($cd_usuario) {
                $usuario = "and ag.cd_usuario = $cd_usuario";
            } else {
                $usuario = "";
            }
//            if (checarStatusMs(M_url_ms::tipo_veiculo) && !($this->verificarAgendamentoIncompleto($dt_ini, $dt_fim, ''))) {
//                $sql = "select ag.*, user.nome, tp.*, sv.*, ta.preco "
//                        . "from agendamento as ag inner join usuario as user on ag.cd_usuario = user.cd_usuario "
//                        . "inner join tipo_veiculo as tp on tp.cd_tpveiculo = ag.cd_tpveiculo "
//                        . "inner join servico as sv on ag.cd_servico = sv.cd_servico "
//                        . "inner join tarifa as ta on tp.cd_tpveiculo = ta.cd_tpveiculo and sv.cd_servico = ta.cd_servico "
//                        . " where data between ? and ? "
//                        . $usuario
//                        . " order by ag.data desc, ag.horario asc";
//            } else {
            $sql = "select ag.*, user.nome, sv.* "
                    . "from agendamento as ag inner join usuario as user on ag.cd_usuario = user.cd_usuario "
                    . "inner join servico as sv on ag.cd_servico = sv.cd_servico "
                    . " where data between ? and ? "
                    . $usuario
                    . " order by ag.data desc, ag.horario asc";
//            }

            return $this->db->query($sql, array($dt_ini, $dt_fim));
        }

        public function getAgendamento($cd_agend, $tipo_veiculo = null) {
//            if (checarStatusMs(M_url_ms::tipo_veiculo) && !($this->verificarAgendamentoIncompleto('', '', $cd_agend))) {
//                $sql = "select ag.*, user.nome, tp.*, sv.*, ta.preco "
//                        . " from agendamento as ag inner join usuario as user on ag.cd_usuario = user.cd_usuario "
//                        . " inner join tipo_veiculo as tp on tp.cd_tpveiculo = ag.cd_tpveiculo "
//                        . " inner join servico as sv on ag.cd_servico = sv.cd_servico "
//                        . " inner join tarifa as ta on tp.cd_tpveiculo = ta.cd_tpveiculo and sv.cd_servico = ta.cd_servico "
//                        . " where cd_agendamento = ?"
//                        . " order by ag.data desc, ag.horario asc";
//            } else {
            $sql = "select ag.*, user.nome, sv.*"
                    . " from agendamento as ag inner join usuario as user on ag.cd_usuario = user.cd_usuario "
                    . " inner join servico as sv on ag.cd_servico = sv.cd_servico "
                    . " where cd_agendamento = ?"
                    . " order by ag.data desc, ag.horario asc";
//        }

            return $this->db->query($sql, $cd_agend);
        }

        public function editarAgendamento($agendamento) {
            $sql = "update agendamento set "
                    . "cd_tpveiculo = ?, cd_servico = ?, "
                    . "placa = ?, data = ?, horario = ? "
                    . "where cd_agendamento = ?";
            return $this->db->query($sql, array($agendamento->tipo_veiculo, $agendamento->servico,
                        $agendamento->placa, $agendamento->data, $agendamento->horario,
                        $agendamento->cd_agendamento));
        }

        public function cadastrarAgendamento($agendamento) {
            $sql = "INSERT INTO agendamento (cd_usuario, cd_tpveiculo, cd_servico, placa, data, horario)
                VALUES (?, ?, ?, ?, ?, ?)";
            return $this->db->query($sql, array($agendamento->usuario, $agendamento->tipo_veiculo, $agendamento->servico,
                        $agendamento->placa, $agendamento->data, $agendamento->horario));
        }

        public function excluirAgendamento($cd_agend) {
            $sql = "delete from agendamento where cd_agendamento = ?";
            return $this->db->query($sql, $cd_agend);
        }

        public function finalizarAgendamento($cd_agend) {
            $this->load->model('m_faturamento');

            $this->db->trans_begin();
            try {
                //atualiza o nome do serviço
                $sql = "update agendamento set status = 1 where cd_agendamento = ?";
                $finalizou = $this->db->query($sql, $cd_agend);


                if ($finalizou === FALSE) {
                    throw new Exception("Erro ao editar na tabela serviço.");
                }

                //pega o objeto agendamento finalizado
                $agendamento = $this->getAgendamento($cd_agend)->row();

                //insere os dados do agendamento finalizado na tabela faturamento
                $faturou = $this->m_faturamento->setFaturamento($agendamento);

                //verifica se houve erros
                if ($finalizou === TRUE && $faturou == TRUE) {
                    $this->db->trans_commit();
                    return 1;
                } else {
                    $this->db->trans_rollback();
                    return 0;
                }
            } catch (Exception $ex) {
                return 0;
            }
        }

    }
