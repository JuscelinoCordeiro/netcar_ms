<script type="text/javascript" language="javascript" src="<?= base_url('assets/js/jn_agendamento.js') ?>"></script>
<div class="row">
    <?php
        if ($agendamentos_dia) {
            ?>
            <div class="col-md-2"></div>
            <div class="col-md-8"><h3 class="titulo text text-center">Agenda para hoje</h3></div>
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
                        <th>AÇÃO</th>
                    </tr>
                </thead>
                <?php
                $i = 0;
                foreach ($agendamentos_dia as $agendamento) {

                    $i = $i + 1;
                    ?>
                    <tr class="text text-center text-uppercase">
                        <td><?= $i ?></td>
                        <td><?= $agendamento->nome ?></td>
                        <td><?= (!empty($agendamento->tipo)) ? $agendamento->tipo : '<span class="text text-danger"><b>Serviço Indisponível</b></span>' ?></td>
                        <td><?= $agendamento->placa ? $agendamento->placa : "---" ?></td>
                        <td><?= $agendamento->servico ?></td>
                        <td><?= dataView($agendamento->data) ?></td>
                        <td><?= horaView($agendamento->horario) ?></td>
                        <td><?= (!empty($agendamento->preco)) ? "R$ " . $agendamento->preco . ",00" : '<span class="text text-danger"><b>Ver valor na tabela da loja</b></sapn>' ?></td>
                        <td class="text-center">
                            <?php
                            $status = $agendamento->status;
                            if ($status == 0) {
                                ?>
                                <span class="label label-warning">
                                    <?php echo "ABERTO"; ?>
                                </span>
                                <?php
                                if (validaPerfil(array(M_perfil::Operador, M_perfil::Gerente), $this->session->userdata('dados_usuario')->nivel)) {
                                    ?>
                                    <a id = "btnFin<?= $agendamento->cd_agendamento ?>" class = "finalizar" cd_agend = "<?= $agendamento->cd_agendamento ?>"><img src = "<?= base_url('assets/img/b_finalizar2.png') ?>" height = "17" width = "17" alt = "finalizar" title = "Finalizar agendamento" border = "0"/></a>
                                    <?php
                                }
                                $tipo = (!empty($agendamento->tipo)) ? $agendamento->tipo : "";
                                ?>

                                <a id="btnEdit<?= $agendamento->cd_agendamento ?>" cd_agend="<?= $agendamento->cd_agendamento ?>" tipo="<?= $tipo ?> "href="#"><img src="<?= base_url('assets/img/b_edit.png') ?>" alt="editar" title="Editar agendamento" border="0"/></a>
                                <a id="btnExc<?= $agendamento->cd_agendamento ?>" cd_agend="<?= $agendamento->cd_agendamento ?>" class="excluir" id="btnExc<?= $agendamento->cd_agendamento ?>" cd_agend="<?= $agendamento->cd_agendamento ?>"><img src="<?= base_url('assets/img/b_excluir.png') ?>" alt="excluir" title="Excluir agendamento" border="0"/></a>
                                <?php
                            } else {
                                echo "SERVIÇO REALIZADO";
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <div class="col-md-2"></div>
        <?php } else { ?>
            <div class="col-md-3"></div>
            <div  id=""class="col-md-6" ><h3>Até o momento não existem agendamentos para hoje, <?= date('d/m/y') ?>.</h3></div>
            <div class="col-md-3"></div>
        <?php } ?>
</div>
