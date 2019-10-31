<?php

    if (!defined('BASEPATH'))
        exit('No	direct script access allowed');

    class M_servico extends CI_Model {

        public function __construct() {
            parent::__construct();
        }

        public function getServicos() {
            $sql = " select * from servico";
            return $this->db->query($sql);
        }

        public function getServicosTpVeiculos($cd_tpveiculo) {
            $this->load->model('m_tarifa');
            $sql = "select s.* from servico as s"
                    . " inner join tarifa as t on s.cd_servico = t.cd_servico "
                    . " where t.cd_tpveiculo = ?";
            return $this->db->query($sql, $cd_tpveiculo);
        }

        public function getServicosAtivos() {
            $sql = " select * from servico where ativo = 1";
            return $this->db->query($sql);
        }

        public function getServicoById($cd_servico) {
            $sql = "select * from servico where cd_servico = ?";
            return $this->db->query($sql, $cd_servico);
        }

        public function excluirServico($cd_servico) {
            $sql = "delete from servico where cd_servico = ?";
            return $this->db->query($sql, $cd_servico);
        }

        public function editarServico($cd_servico, $servico, $tipo_veiculos) {

            $this->load->model('m_tarifa');


            try {
                //atualiza o nome do serviço
                $sql = "update servico set servico = ? where cd_servico = ?";
                $up_servico = $this->db->query($sql, array($servico, $cd_servico));

                if ($up_servico === FALSE) {
                    throw new Exception("Erro ao editar na tabela serviço.");
                }

                $this->db->trans_begin();
                //VERIFICA CONDIÇAO DO MICROSSERVIÇO DE TIPO_VEICULOS
                if (checarStatusMs(M_url_ms::tipo_veiculo)) {
                    //pega as tarifas existentes por servico/tipo_veiculo
                    $tarifas = $this->m_tarifa->getTarifaServico($cd_servico)->result();
                    $tarifados = array();
                    foreach ($tarifas as $tarifa) {
                        array_push($tarifados, $tarifa->cd_tpveiculo);
                    }

                    //se o tipo se serviço por tipo_veiculo nao estiver tarifado, cadastra na tabela tarifas
                    $result_up_tarifa = TRUE;
                    foreach ($tipo_veiculos as $tpveiculo) {
                        if (!in_array($tpveiculo, $tarifados)) {
                            $result_up_tarifa = $this->m_tarifa->cadastrarTarifa($tpveiculo, $cd_servico);
                            if ($result_up_tarifa === FALSE) {
                                throw new Exception("Erro ao cadastrar na tabela tarifa.");
                            }
                        }
                    }

                    //se o serviço por tipo_veiculo deixou de existe, remover da tebela tarifas
                    $result_del_tarifa = TRUE;
                    foreach ($tarifados as $tarifado) {
                        if (!in_array($tarifado, $tipo_veiculos)) {
                            $result_del_tarifa = $this->m_tarifa->excluirTarifaTpVeiculo($tarifado, $cd_servico);

                            if ($result_del_tarifa === FALSE) {
                                throw new Exception("Erro ao cadastrar na tabela tarifa.");
                            }
                        }
                    }

                    //verifica se houve erros
                    if ($result_up_tarifa === TRUE && $result_del_tarifa == TRUE) {
                        $this->db->trans_commit();
                        return 1;
                    } else {
                        $this->db->trans_rollback();
                        return 0;
                    }
                } else {
                    return $up_servico;
                }
            } catch (Exception $ex) {
                return 0;
            }
        }

        public function getCodigoUltimoServico() {
            $sql = "select MAX(cd_servico) ultimo_cod from servico";
            return $this->db->query($sql);
        }

        public function cadastrarServico($servico, $tipo_veiculos) {
            $this->load->model('m_tarifa');


            try {

                $sql_ultimoSv = "select MAX(cd_servico) ultimo_cod from servico";
                $ultimoCod = $this->db->query($sql_ultimoSv)->row()->ultimo_cod;

                if ($ultimoCod) {
                    $novo_cod = $ultimoCod + 1;
                } else {
                    $novo_cod = 1;
                }

                $sql_servico = "insert into servico (cd_servico, servico) values (?, ?)";
                $insert1 = $this->db->query($sql_servico, array($novo_cod, $servico));

                if ($insert1 === FALSE) {
                    throw new Exception("Erro ao cadastrar na tabela serviço.");
                }

                $this->db->trans_begin();
                if (checarStatusMs(M_url_ms::tipo_veiculo)) {
                    $insert2 = TRUE;
                    if (!empty($tipo_veiculos)) {
                        foreach ($tipo_veiculos as $tpv) {
                            $insert2 = $this->m_tarifa->cadastrarTarifa($tpv, $novo_cod);

                            if ($insert2 === FALSE) {
                                throw new Exception("Erro ao cadastrar na tabela tarifa.");
                            }
                        }
                    }


                    if ($insert1 === TRUE && $insert2 == TRUE) {
                        return 1;
                        $this->db->trans_commit();
                    } else {
                        $this->db->trans_rollback();
                        return 0;
                    }
                } else {
                    return $insert1;
                }
            } catch (Exception $ex) {
                return 0;
            }
        }

        public function mudarStatus($cd_servico, $status) {
            $sql = "update servico set ativo = ? where cd_servico = ?";
            return $this->db->query($sql, array((int) $status, $cd_servico));
        }

    }
