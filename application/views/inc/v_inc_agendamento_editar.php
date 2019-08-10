<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>

<?php
//    print_r($agendamento);
//    print_r($servicos);
//    print_r($tipo_veiculos);
//    die();
?>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h2 class="titulo">Editar agendamento</h2>
        <form id="form_cad_agendamento" action="" method="post">
            <legend class="text-black hr3">Dados do agendamento</legend>
            <div class="form-group">
                <label class="control-label">Nome</label>
                <input class="form-control  text text-uppercase" type="text" name="nome" disabled="" cd_usuario="<?= $agendamento->cd_usuario ?>" value="<?= $agendamento->nome ?>"/>
            </div>
            <div class="form-group">
                <label class="control-label">Placa do veículo</label>
                <input class="form-control  text text-uppercase" type="text" name="placa" value="<?= $agendamento->placa ? $agendamento->placa : "---" ?>"/>
            </div>
            <div class="form-group">
                <label for="Perfil" class="control-label">Tipo de veiculo</label>
                <select class="form-control text text-uppercase" name="tipo_veiculo" id="tipo_veiculo"  required >
                    <option value="" selected="">Selecione o tipo de veículo</option>
                    <?php
                        foreach ($tipo_veiculos as $tpveiculos) {
                            if ($agendamento->cd_tpveiculo == $tpveiculos->cd_tpveiculo) {
                                $selecionado = "selected";
                            } else {
                                $selecionado = "";
                            }
                            echo '<option ' . $selecionado . ' value="' . $tpveiculos->cd_tpveiculo . '">' . $tpveiculos->tipo . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Perfil" class="control-label">Serviço</label>
                <select class="form-control text text-uppercase" name="servico" id="servico"  required>
                    <option value="">Selecione o tipo de veículo primeiro</option>
                    <?php
                        foreach ($servicos as $servico) {
                            if ($agendamento->cd_servico == $servico->cd_servico) {
                                $selecionado = "selected";
                            } else {
                                $selecionado = "";
                            }
                            echo '<option ' . $selecionado . ' value="' . $servico->cd_servico . '">' . $servico->servico . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-inline">
                <div class="form-group">
                    <label class="control-label">Data</label>
                    <span id="dt_agenda">
                        <div class="controls">
                            <input class="form-control text text-uppercase" id="data_agenda" type="text" name="data" value="<?= inverteData($agendamento->data) ?>"/>
                            <span class="textfieldInvalidFormatMsg msg">Formato de data inválido.</span>
                        </div>
                    </span>
                </div>
                <!--hora-->
                <div class="form-group">
                    <label class="control-label">Horário: </label>
                    <span id="h_agenda">
                        <div class="controls">
                            <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                <input type="text" name="horario" class="form-control" value="<?= date("H:i", strtotime($agendamento->horario)) ?>">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                <span class="textfieldInvalidFormatMsg msg">Formato de hora inválido.</span>
                            </div>
                        </div>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Valor</label>
                <input class="form-control  text text-uppercase" type="text" name="preco" id="preco" required value="R$ <?= $agendamento->preco ?>,00"/>
            </div>
            <input type="hidden" name="acao" value="editar"/>
            <input type="hidden" name="cd_agend" value="<?= $agendamento->cd_agendamento ?>"/>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>

<script>
    //editar o agendamento
    $(document).ready(function() {
        $("#salvarModal").click(function(e) {
            cd_agend = $("input[name=cd_agend]").val();
            cd_usuario = $(this).attr('cd_usuario');
            placa = $("input[name=placa]").val();
            cd_tpveiculo = $("select[name=tipo_veiculo]").val();
            cd_servico = $("select[name=servico]").val();
            data = $("input[name=data]").val();
            horario = $("input[name=horario]").val();
            valor = $("input[name=preco]").val();
            acao = $("input[name=acao]").val();

            $.ajax({
                type: 'POST',
                url: '/netcar/c_agendamento/editarAgendamento',
                cache: false,
                data: {
                    cd_agend: cd_agend,
                    cd_usuario: cd_usuario,
                    placa: placa,
                    cd_tpveiculo: cd_tpveiculo,
                    cd_servico: cd_servico,
                    data: data,
                    horario: horario,
                    valor: valor,
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
                        var msg = 'Agendamento realizado com sucesso.';
                        $('#sucessoTexto').html(msg);
                        $('#sucesso').modal('show');
                    } else {
                        $('#erro').on('hidden.bs.modal', function(e) {
                            window.location.reload();
                        });
                        $('#excluir').modal('hide');
                        var msg = 'ERRO ao cadastrar agendamento.';
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


        //combobox servico
        $('#tipo_veiculo').on('change', function() {
            var cd_tpveiculo = $(this).val();
            if (cd_tpveiculo) {
                $.ajax({
                    type: 'POST',
                    url: '/netcar/c_servico/comboServicos',
                    data: {cd_tpveiculo: cd_tpveiculo},
                    success: function(html) {
                        $('#servico').html(html);
                        $('#preco').val('Selecione o tipo de veículo e o serviço.');
                    }
                });
            } else {
                $('#servico').html('<option value="">Selecione primeiro o tipo de veículo.</option>');
                $('#preco').html('<option value="">Selecione primeiro o serviço.</option>');
            }
        });

        //combobox preço
        $('#servico').on('change', function() {
            var cd_servico = $(this).val();
            var cd_tpveiculo = $('#tipo_veiculo').val();
            if (cd_servico) {
                $.ajax({
                    type: 'POST',
                    url: '/netcar/c_tarifa/getTarifaServicoTpVeiculo',
                    data: {
                        cd_servico: cd_servico,
                        cd_tpveiculo: cd_tpveiculo
                    },
                    success: function(html) {
                        $('#preco').val(html);
                    }
                });
            } else {
                $('#preco').val('Serviço não tarifado');
            }
        });
    });

    $(function() {
        $("#data_agenda").datepicker(
                {
                    dateFormat: 'dd/mm/yy',
                    dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
                    dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
                    dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
                });
    });
    $('.clockpicker').clockpicker();
    var dt_agenda = new Spry.Widget.ValidationTextField("data", "date", {format: "dd/mm/yyyy", useCharacterMasking: true});
    var h_agenda = new Spry.Widget.ValidationTextField("horario", "time", {format: "HH:mm", useCharacterMasking: true});
</script>
