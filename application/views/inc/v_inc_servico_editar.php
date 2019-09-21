<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h2 class="titulo">Editar Serviço</h2>
        <!--<a class="btn btn-success pull-right" href="/netcar/index.jsp"><i class="icon-arrow-left icon-white"></i>Voltar</a>-->
        <form id="form_cad_usuario" action="" method="post">
            <legend class="text-black hr3">Dados do Serviço</legend>
            <div class="form-group">
                <label class="control-label">Tipo de serviço</label>
                <input class="form-control text text-uppercase" type="text" name="servico" required value="<?= $servico->servico ?>"/>
            </div>
            <div class="form-group">
                <label class="control-label">Tipos de veículos</label>
            </div>
            <?php
                if ($tipo_veiculos == M_http_code::not_found) {
                    echo '<h4 class="text text-danger text-center"><b>Serviço Indisponível</b></h4>';
                } else {
                    foreach ($tipo_veiculos as $tpVeiculo) {
                        $check = "";
                        foreach ($tarifas as $tarifa) {
                            if ($tpVeiculo->id == $tarifa->cd_tpveiculo) {
                                $check = "checked";
                            }
                        }
                        ?>
                        <label class="checkbox-inline">
                            <input class=" text text-uppercase"type="checkbox" name="check" id="tpv<?= $tpVeiculo->id ?>" value="<?= $tpVeiculo->id ?>" <?= $check ?> > <?= $tpVeiculo->tipo ?>
                        </label>
                        <?php
                    }
                }
            ?>

            <input type="hidden" name="acao" value="editar"/>
            <input type="hidden" name="cd_servico" value="<?= $servico->cd_servico ?>"/>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>
<script>
    $(document).ready(function() {
        $("#salvarModal").click(function(e) {
            servico = $("input[name=servico]").val();
            cd_servico = $("input[name=cd_servico]").val();
            acao = $("input[name=acao]").val();
            var tipo_veiculos = new Array();
            $("input[name=check]:checked").each(function() {
                tipo_veiculos.push($(this).val());
            });

            $.ajax({
                type: 'POST',
                url: '/netcar/c_servico/editarServico',
                cache: false,
                data: {
                    servico: servico,
                    cd_servico: cd_servico,
                    tipo_veiculos: tipo_veiculos,
                    acao: acao
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
                        var msg = 'Serviço alterado com sucesso.';
                        $('#sucessoTexto').html(msg);
                        $('#sucesso').modal('show');
                    } else {
                        $('#erro').on('hidden.bs.modal', function(e) {
                            window.location.reload();
                        });
                        $('#excluir').modal('hide');
                        var msg = 'ERRO ao alterar o serviço.';
                        $('#erroTexto').html(msg);
                        $('#erro').modal('show');
                    }
                },
                error: function() {
                    $("#erroTexto").html("Erro no sistema, tente novamente.");
                    $("#erro").modal('show');
                }
            });
            e.preventDefault();
        });
    });
</script>