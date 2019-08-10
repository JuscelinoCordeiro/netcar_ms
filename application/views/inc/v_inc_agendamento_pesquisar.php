<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h2 class="titulo">Pesquisar agendamentos</h2>
        <!--<a class="btn btn-success pull-right" href="/netcar/index.jsp"><i class="icon-arrow-left icon-white"></i>Voltar</a>-->
        <form id="form_cad_usuario" action="" method="post">
            <legend class="text-black hr3">Informa as datas para pesquisa</legend>
            <div class="form-inline">
                <div class="form-group">
                    <label class="control-label">Data inicial</label>
                    <span id="dt_agenda">
                        <div class="controls">
                            <input class="form-control" id="data_agenda" type="text" name="data_inicio" placeholder="dd/mm/aaaa"/>
                            <span class="textfieldInvalidFormatMsg msg">Formato de data inválido.</span>
                        </div>
                    </span>
                </div>
                <div class="form-group pull-right">
                    <label class="control-label">Data final</label>
                    <span id="dt_agenda2">
                        <div class="controls">
                            <input  class="form-control" id="data_agenda2" type="text" name="data_fim" placeholder="dd/mm/aaaa"/>
                            <span class="textfieldInvalidFormatMsg msg">Formato de data inválido.</span>
                        </div>
                    </span>
                </div>
            </div>
            <input type="hidden" name="acao" value="pesquisar"/>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>
<script>
//    $(function() {
    $("#data_agenda").datepicker(
            {
                dateFormat: 'dd/mm/yy',
                dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
                dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
            });
    $("#data_agenda2").datepicker(
            {
                dateFormat: 'dd/mm/yy',
                dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
                dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
                dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
            });
//    });


    $(document).ready(function () {
        $("#salvarModal").html("Pesquisar");
        $("#fecharModal").html("Cancelar");

        $("#salvarModal").click(function (e) {
            dt_inicio = $("input[name=data_inicio]").val();
            dt_fim = $("input[name=data_fim]").val();
            acao = $("input[name=acao]").val();

            $.ajax({
                type: 'POST',
                url: '/netcar/c_agendamento/listarAgendamentos',
                cache: false,
                data: {
                    dt_inicio: dt_inicio,
                    dt_fim: dt_fim,
                    acao: acao
                },
                beforeSend: function (xhr) {
                    xhr.overrideMimeType("text/plain; charset=UTF-8");
                },
                complete: function () {
                },
                success: function (data) {
                    $('#modalTexto').on('hidden.bs.modal', function (e) {
                        window.location.reload();
                    });
                    $('#modal').modal('hide');
                    $("#resposta_ajax").empty();
                    $("#resposta_ajax").html(data);
//                    $("#modal").modal('show');
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