<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 text text-center"><h3 class="titulo">Veículos</h3></div>
    <div class="col-md-2"></div>
    <table class="tabela table table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th>ORD</th>
                <th>TIPO DE VEÍCULO</th>
                <th>AÇÃO</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 1;
                foreach ($veiculos->result() as $veiculo) {
                    ?>
                    <tr>
                        <td class="text text-center"><?= $i ?></td>
                        <td class="text-uppercase text text-center"><?= $veiculo->tipo ?></td>
                        <td class="text text-center">
                            <a href="#" id="btnEdit<?= $veiculo->cd_tpveiculo ?>" cd_tpveiculo="<?= $veiculo->cd_tpveiculo ?>"><img src="<?= base_url('assets/img/b_edit.png') ?>" alt="editar" title="Editar" border="0"/></a>
                            <a id="btnExc<?= $veiculo->cd_tpveiculo ?>" class="excluir" veiculo="<?= $veiculo->tipo ?>" cd_tpveiculo="<?= $veiculo->cd_tpveiculo ?>" ><img src="<?= base_url('assets/img/b_excluir.png') ?>" alt="excluir" title="Excluir o veículo" border="0"/></a>
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
    // EDITAR O SERVIÇO
    $("a[id^=btnEdit]").click(function (e) {
        cd_tpveiculo = $(this).attr('cd_tpveiculo');

        $.ajax({
            type: 'POST',
            url: '/netcar/c_veiculo/editarVeiculo',
            cache: false,
            data: {
                cd_tpveiculo: cd_tpveiculo
            },
            beforeSend: function (xhr) {
                xhr.overrideMimeType("text/plain; charset=UTF-8");
            },
            complete: function () {
            },
            success: function (data) {
                $("#modalTexto").html(data);
                $("#modal").modal('show');
            },
            error: function () {
                $("#erroTexto").html("erro");
                $("#erro").modal('show');
            }
        });
        e.preventDefault();
    });


    //EXCLUIR O SERVIÇO
    $('a[id^=btnExc]').click(function () {

        cd_tpveiculo = $(this).attr('cd_tpveiculo');

        $('#excluir').on('shown.bs.modal', function (e) {

            $('#excluirModal').click(function () {
                $.ajax({
                    type: "POST",
                    url: '/netcar/c_veiculo/excluirVeiculo',
                    cache: false,
                    data: {cd_tpveiculo: cd_tpveiculo},
                    beforeSend: function (xhr) {
                        xhr.overrideMimeType("text/plain; charset=UTF-8");
                    },
                    complete: function () {
                    },
                    success: function (data) {
                        if (data === '1') {

                            $('#sucesso').on('hidden.bs.modal', function (e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'Veículo excluído com sucesso!';
                            $('#sucessoTexto').html(msg);
                            $('#sucesso').modal('show');

                        } else {

                            $('#erro').on('hidden.bs.modal', function (e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'ERRO ao excluir o veículo.';
                            $('#erroTexto').html(msg);
                            $('#erro').modal('show');
                        }
                    },
                    error: function () {
                        $("#erro").html('Ocorreu um erro no sistema.');
                        $("#erro").dialog("open");
                    }
                });
            });

        });

        $("#excluirTexto").html('<b>Confirma a exclusão do veículo?</b>');
        $("#excluir").modal("show");

    });

</script>