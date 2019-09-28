<script type="text/javascript" language="javascript" src="<?= base_url('assets/js/jn_agendamento.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
<style>
    #visualizar{
        width: 90%;
        z-index: 2000;
    }
</style>
<div class="row">
    <?php
        if ($agendamentos) {
            ?>
            <div class="col-md-2"></div>
            <div class="col-md-8 text text-center"><h3 class="titulo">Agendamentos para o período de <?= inverteData($dt_inicio) . " a " . inverteData($dt_fim) ?></h3></div>

            <table class="tabela table table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>ORD</th>
                        <th>USUÁRIO</th>
                        <th>TIPO DE VEICULO</th>
                        <th>PLACA</th>
                        <th>SERVIÇO</th>
                        <th>DATA</th>
                        <th>HORÁRIO</th>
                        <th>VALOR</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <?php
                $i = 0;
                foreach ($agendamentos as $ag) {
                    $i = $i + 1;
                    ?>
                    <tr class="text text-center text-uppercase">
                        <td><?= $i ?></td>
                        <td><?= $ag->nome ?></td>
                        <td><?= $ag->tipo ?></td>
                        <td><?= $ag->placa ? $ag->placa : "---" ?></td>
                        <td><?= $ag->servico ?></td>
                        <td><?= date('d/m/Y', strtotime($ag->data)) ?></td>
                        <td><?= $ag->horario ?></td>
                        <td><?= ($ag->preco !== 'Sem Informação') ? "R$ " . $ag->preco . ",00" : $ag->preco ?></td>
                        <td class="text-center">
                            <?php
                            $status = $ag->status;
                            if ($status == 0) {
                                ?>
                                <span class="label label-warning">
                                    <?php echo "ABERTO"; ?>
                                </span>
                                <?php
                                if (validaPerfil(array(M_perfil::Operador, M_perfil::Gerente), $this->session->userdata('dados_usuario')->nivel)) {
                                    if (!empty($ag->cd_tpveiculo)) {
                                        ?>
                                        <a id="btnFin<?= $ag->cd_agendamento ?>" class="finalizar" cd_agend="<?= $ag->cd_agendamento ?>"><img src="<?= base_url('assets/img/b_finalizar2.png') ?>" height="17" width="17" alt="finalizar" title="Finalizar agendamento" border="0"/></a>
                                        <?php
                                    }
                                }
                                $tipo = (!empty($ag->tipo)) ? $ag->tipo : "";
                                ?>
                                <a id="btnEdit<?= $ag->cd_agendamento ?>" cd_agend="<?= $ag->cd_agendamento ?>" tipo="<?= $tipo ?> "href="#"><img src="<?= base_url('assets/img/b_edit.png') ?>" alt="editar" title="Editar agendamento" border="0"/></a>
                                <a id="btnExc<?= $ag->cd_agendamento ?>" cd_agend="<?= $ag->cd_agendamento ?>" class="excluir" id="btnExc<?= $ag->cd_agendamento ?>" cd_agend="<?= $ag->cd_agendamento ?>"><img src="<?= base_url('assets/img/b_excluir.png') ?>" alt="excluir" title="Excluir agendamento" border="0"/></a>

                                <?php
                            } else {
                                echo "SERVIÇO REALIZADO";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <div class="col-md-2"></div>
            <?php } else { ?>
                <div class="col-md-3"></div>
                <div  id=""class="col-md-6" ><h3>Não existem agendamentos para o período de <?= inverteData($dt_inicio) . " a " . inverteData($dt_fim) ?>.</h3></div>
                <div class="col-md-3"></div>
            <?php } ?>
    </table>
</div>
