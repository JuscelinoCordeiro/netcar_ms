<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h2 class="titulo">Cadastrar Serviço</h2>
        <form id="form_cad_usuario" action="" method="post">
            <legend class="text-black hr3">Dados do Serviço</legend>
            <div class="form-group">
                <label class="control-label">Tipo de serviço</label>
                <input class="form-control  text text-uppercase" type="text" name="servico" required />
            </div>
            <div class="form-group">
                <label class="control-label">Tipos de veículos</label>
            </div>
            <?php
                foreach ($tipo_veiculos as $tpVeiculo) {
                    ?>
                    <label class="checkbox-inline">
                        <input class=" text text-uppercase"type="checkbox" name="check" id="tpv<?= $tpVeiculo->id ?>" value="<?= $tpVeiculo->id ?>"> <?= $tpVeiculo->tipo ?>
                    </label>
                    <?php
                }
            ?>

            <input type="hidden" name="acao" value="cadastrar"/>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>

<script>
    $(document).ready(function() {
        $("#salvarModal").click(function(e) {
            servico = $("input[name=servico]").val();
            acao = $("input[name=acao]").val();
            var tipo_veiculos = new Array();
            $("input[name=check]:checked").each(function() {
                tipo_veiculos.push($(this).val());
            });

            $.ajax({
                type: 'POST',
                url: '/netcar/c_servico/cadastrarServico',
                cache: false,
                data: {
                    servico: servico,
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
                        var msg = 'Serviço cadastrado com sucesso.';
                        $('#sucessoTexto').html(msg);
                        $('#sucesso').modal('show');
                    } else {
                        $('#erro').on('hidden.bs.modal', function(e) {
                            window.location.reload();
                        });
                        $('#excluir').modal('hide');
                        var msg = 'ERRO ao cadastrar o serviço.';
                        $('#erroTexto').html(msg);
                        $('#erro').modal('show');
                    }
                },
                error: function() {
                    $("#erroTexto").html("Erro no sistema ao cadastrar, tente novamente.");
                    $("#erro").modal('show');
                }
            });
            e.preventDefault();
        });
    });
</script>