<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h2 class="titulo">Editar Preço</h2>
        <!--<a class="btn btn-success pull-right" href="/netcar/index.jsp"><i class="icon-arrow-left icon-white"></i>Voltar</a>-->
        <form id="form_cad_usuario" action="" method="post">
            <legend class="text-black hr3">Dados do Serviço</legend>
            <div class="form-group">
                <label class="control-label">Tipo de serviço</label>
                <input class="form-control text text-uppercase" disabled type="text" name="servico" required value="<?= $servico->servico ?>"/>
            </div>
            <div class="form-group">
                <label class="control-label">Tipo de veículo</label>
                <input class="form-control text text-uppercase" disabled type="text" name="servico" required value="<?= $tipo_veiculo->tipo ?>"/>
            </div>
            <div class="form-group">
                <label class="control-label">Preço</label>
                <input class="form-control text text-uppercase" type="text" name="preco" required value="<?= $tarifa->preco ?>"/>
            </div>

            <input type="hidden" name="acao" value="editar"/>
            <input type="hidden" name="cd_servico" value="<?= $servico->cd_servico ?>"/>
            <input type="hidden" name="cd_tpveiculo" value="<?= $tipo_veiculo->cd_tpveiculo ?>"/>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>
<script>
    $(document).ready(function () {
        $("#salvarModal").click(function (e) {
            cd_servico = $("input[name=cd_servico]").val();
            cd_tpveiculo = $("input[name=cd_tpveiculo]").val();
            preco = $("input[name=preco]").val();
            acao = $("input[name=acao]").val();

            $.ajax({
                type: 'POST',
                url: '/netcar/c_tarifa/editarTarifa',
                cache: false,
                data: {
                    cd_servico: cd_servico,
                    cd_tpveiculo: cd_tpveiculo,
                    preco: preco,
                    acao: acao
                },
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
                        $('#alteracao').modal('hide');
                        var msg = 'Tarifa alterada com sucesso.';
                        $('#sucessoTexto').html(msg);
                        $('#sucesso').modal('show');
                    } else {
                        $('#erro').on('hidden.bs.modal', function (e) {
                            window.location.reload();
                        });
                        $('#excluir').modal('hide');
                        var msg = 'ERRO ao alterar tarifa.';
                        $('#erroTexto').html(msg);
                        $('#erro').modal('show');
                    }
                },
                error: function () {
                    $("#erroTexto").html("Erro no sistema, tente novamente.");
                    $("#erro").modal('show');
                }
            });
            e.preventDefault();
        });
    });
</script>