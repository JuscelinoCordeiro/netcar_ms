<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 text text-center"><h3 class="titulo">Serviços</h3></div>
    <div class="col-md-2"></div>
    <table class="tabela table table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th>ORD</th>
                <th>TIPO DE SERVIÇO</th>
                <th>STATUS</th>
                <th>AÇÃO</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($servicos->result() as $servico) {
                ?>
                <tr>
                    <td class="text text-center"><?= $i ?></td>
                    <td class="text-uppercase text text-center"><?= $servico->servico ?></td>
                    <td class="text text-center"><?= $servico->ativo == '1' ? 'ATIVO' : 'DESATIVADO' ?></td>
                    <td class="text text-center">
                        <?php
                        if ($servico->ativo === '1') {
                            ?>
                            <a href="#" id="btnDes" cd_servico="<?= $servico->cd_servico ?>">
                                <img src="<?= base_url('assets/img/b_desativar2.jpeg') ?>" height="15" width="15" alt="desativar_serviço" title="Desativar serviço" border="0"/>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href="#" id="btnAtiv" cd_servico="<?= $servico->cd_servico ?>">
                                <img src="<?= base_url('assets/img/b_ativar.jpeg') ?>" height="15" width="15" alt="ativar_serviço" title="Ativar serviço" border="0"/>
                            </a>
                            <?php
                        }
                        ?>

                        <a href="#" id="btnEdit<?= $servico->cd_servico ?>" cd_servico="<?= $servico->cd_servico ?>"><img src="<?= base_url('assets/img/b_edit.png') ?>" alt="editar" title="Editar" border="0"/></a>
                        <a id="btnExc<?= $servico->servico ?>" class="excluir" servico="<?= $servico->servico ?>" cd_servico="<?= $servico->cd_servico ?>" ><img src="<?= base_url('assets/img/b_excluir.png') ?>" alt="excluir" title="Excluir o serviço" border="0"/></a>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    //ATIVAR SERVIÇO
    $('a[id^=btnAtiv]').click(function() {

        cd_servico = $(this).attr('cd_servico');
        status = '1';
        $('#alteracao').on('shown.bs.modal', function(e) {

            $('#alteracaoModal').click(function() {
                $.ajax({
                    type: "POST",
                    url: '/netcar/c_servico/mudarStatus',
                    cache: false,
                    data: {
                        cd_servico: cd_servico,
                        status: status
                    },
                    beforeSend: function(xhr) {
                        xhr.overrideMimeType("text/plain; charset=UTF-8");
                    },
                    complete: function() {
                    },
                    success: function(data) {
                        if (data === '1') {

                            $('#sucesso').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#alteracao').modal('hide');
                            var msg = 'Serviço ativado com sucesso!';
                            $('#sucessoTexto').html(msg);
                            $('#sucesso').modal('show');

                        } else {

                            $('#erro').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'ERRO ao ativar o serviço.';
                            $('#erroTexto').html(msg);
                            $('#erro').modal('show');
                        }
                    },
                    error: function() {
                        $("#erro").html('Ocorreu um erro no sistema.');
                        $("#erro").dialog("open");
                    }
                });
            });

        });

        $("#alteracaoTexto").html('<b>Confirma a ativação do serviço?</b>');
        $("#alteracao").modal("show");

    });


    // DESATIVAR SERVIÇO
    $('a[id^=btnDes]').click(function() {

        cd_servico = $(this).attr('cd_servico');
        status = '0';
        $('#alteracao').on('shown.bs.modal', function(e) {

            $('#alteracaoModal').click(function() {
                $.ajax({
                    type: "POST",
                    url: '/netcar/c_servico/mudarStatus',
                    cache: false,
                    data: {
                        cd_servico: cd_servico,
                        status: status
                    },
                    beforeSend: function(xhr) {
                        xhr.overrideMimeType("text/plain; charset=UTF-8");
                    },
                    complete: function() {
                    },
                    success: function(data) {
                        if (data === '1') {

                            $('#sucesso').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#alteracao').modal('hide');
                            var msg = 'Serviço desativado com sucesso!';
                            $('#sucessoTexto').html(msg);
                            $('#sucesso').modal('show');

                        } else {

                            $('#erro').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'ERRO ao desativar o serviço.';
                            $('#erroTexto').html(msg);
                            $('#erro').modal('show');
                        }
                    },
                    error: function() {
                        $("#erro").html('Ocorreu um erro no sistema.');
                        $("#erro").dialog("open");
                    }
                });
            });

        });

        $("#alteracaoTexto").html('<b>Confirma a desativação do serviço?</b>');
        $("#alteracao").modal("show");

    });

    // EDITAR O SERVIÇO
    $("a[id^=btnEdit]").click(function(e) {
        cd_servico = $(this).attr('cd_servico');
        $.ajax({
            type: 'POST',
            url: '/netcar/c_servico/editarServico',
            cache: false,
            data: {
                cd_servico: cd_servico
            },
            beforeSend: function(xhr) {
                xhr.overrideMimeType("text/plain; charset=UTF-8");
            },
            complete: function() {
            },
            success: function(data) {
                $("#modalTexto").html(data);
                $("#modal").modal('show');
            },
            error: function() {
                $("#erroTexto").html("erro");
                $("#erro").modal('show');
            }
        });
        e.preventDefault();
    });

    //EXCLUIR O SERVIÇO
    $('a[id^=btnExc]').click(function() {

        cd_servico = $(this).attr('cd_servico');

        $('#excluir').on('shown.bs.modal', function(e) {

            $('#excluirModal').click(function() {
                $.ajax({
                    type: "POST",
                    url: '/netcar/c_servico/excluirServico',
                    cache: false,
                    data: {cd_servico: cd_servico},
                    beforeSend: function(xhr) {
                        xhr.overrideMimeType("text/plain; charset=UTF-8");
                    },
                    complete: function() {
                    },
                    success: function(data) {
                        if (data === '1') {

                            $('#sucesso').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'Serviço excluído com sucesso!';
                            $('#sucessoTexto').html(msg);
                            $('#sucesso').modal('show');

                        } else {

                            $('#erro').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'ERRO ao excluir o serviço.';
                            $('#erroTexto').html(msg);
                            $('#erro').modal('show');
                        }
                    },
                    error: function() {
                        $("#erro").html('Ocorreu um erro no sistema.');
                        $("#erro").dialog("open");
                    }
                });
            });

        });

        $("#excluirTexto").html('<b>Confirma a exclusão do serviço?</b>');
        $("#excluir").modal("show");

    });

</script>