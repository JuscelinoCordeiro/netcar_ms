<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h2 class="titulo">Agendar serviço</h2>
        <form id="form_cad_agendamento" action="" method="post">
            <legend class="text-black hr3">Dados para cadastrar</legend>
            <div class="form-group">
                <label class="control-label">Nome</label>
                <select class="form-control text text-uppercase" name="usuario" >
                    <option value="" selected="">Selecione o usuario</option>
                    <?php
                        foreach ($usuarios as $usuario) {
                            echo '<option class="text text-uppercase" value="' . $usuario->cd_usuario . '">' . $usuario->nome . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Placa do veículo</label>
                <input class="form-control  text text-uppercase" type="text" name="placa" required placeholder="Digite a placa do veículo (opcional)"/>
            </div>
            <div class="form-group">
                <label for="Perfil" class="control-label">Tipo de veiculo</label>
                <select class="form-control text text-uppercase" name="tipo_veiculo" id="tipo_veiculo"  required >
                    <option value="" selected="">Selecione o tipo de veículo</option>
                    <?php
                        foreach ($tipo_veiculos as $tpveiculos) {
                            echo '<option value="' . $tpveiculos->cd_tpveiculo . '">' . $tpveiculos->tipo . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Perfil" class="control-label">Serviço</label>
                <select class="form-control text text-uppercase" name="servico" id="servico"  required>
                    <option value="">Selecione o tipo de veículo primeiro</option>
                </select>
            </div>
            <div class="form-inline">
                <div class="form-group">
                    <label class="control-label">Data</label>
                    <span id="dt_agenda">
                        <div class="controls">
                            <input class="form-control text text-uppercase" id="data_agenda" type="text" name="data" placeholder="Ex.: dd/mm/aaaa"/>
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
                                <input type="text" name="horario" class="form-control">
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
                <input class="form-control  text text-uppercase" type="text" name="preco" id="preco" required value="Selecione o tipo de veículo e o serviço."/>
            </div>
            <input type="hidden" name="acao" value="novoAgendamento"/>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>

<script>
    $(document).ready(function () {
        //cadastrar o agendamento
        $("#salvarModal").click(function (e) {
            cd_usuario = $("select[name=usuario]").val();
            placa = $("input[name=placa]").val();
            cd_tpveiculo = $("select[name=tipo_veiculo]").val();
            cd_servico = $("select[name=servico]").val();
            data = $("input[name=data]").val();
            horario = $("input[name=horario]").val();
//            valor = $("input[name=preco]").val();
            acao = $("input[name=acao]").val();

            $.ajax({
                type: 'POST',
                url: '/netcar/c_agendamento/cadastrarAgendamento',
                cache: false,
                data: {
                    cd_usuario: cd_usuario,
                    placa: placa,
                    cd_tpveiculo: cd_tpveiculo,
                    cd_servico: cd_servico,
                    data: data,
                    horario: horario,
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
                        var msg = 'Agendamento realizado com sucesso.';
                        $('#sucessoTexto').html(msg);
                        $('#sucesso').modal('show');
                    } else {
                        $('#erro').on('hidden.bs.modal', function (e) {
                            window.location.reload();
                        });
                        $('#excluir').modal('hide');
                        var msg = 'ERRO ao cadastrar agendamento.';
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


        //combobox servico
        $('#tipo_veiculo').on('change', function () {
            var cd_tpveiculo = $(this).val();
            if (cd_tpveiculo) {
                $.ajax({
                    type: 'POST',
                    url: '/netcar/c_servico/comboServicos',
                    data: {cd_tpveiculo: cd_tpveiculo},
                    success: function (html) {
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
        $('#servico').on('change', function () {
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
                    success: function (html) {
                        $('#preco').val(html);
                    }
                });
            } else {
                $('#preco').val('Serviço não tarifado');
            }
        });
    });

    $(function () {
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
