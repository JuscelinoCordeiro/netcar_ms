$(document).ready(function() {

    //ESCLUIR SERVICO
    $('a[id^=btnExc]').click(function() {
        cd_agend = $(this).attr('cd_agend');
        $('#excluir').on('shown.bs.modal', function(e) {

            $('#excluirModal').click(function() {
                $.ajax({
                    type: "POST",
                    url: '/netcar/c_agendamento/excluirAgendamento',
                    cache: false,
                    data: {cd_agend: cd_agend},
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
                            var msg = 'Agendamento excluído com sucesso!';
                            $('#sucessoTexto').html(msg);
                            $('#sucesso').modal('show');
                        } else {
                            $('#erro').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'ERRO ao excluir o agendamento.';
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

        $("#excluirTexto").html('<b>Confirma a exclusão do agendamento?</b>');
        $("#excluir").modal("show");

    });

    //FINALIZAR SERVIÇO
    //ATIVAR SERVIÇO
    $('a[id^=btnFin]').click(function() {

        cd_agend = $(this).attr('cd_agend');
        $('#alteracao').on('shown.bs.modal', function(e) {

            $('#alteracaoModal').click(function() {
                $.ajax({
                    type: "POST",
                    url: '/netcar/c_agendamento/finalizarAgendamento',
                    cache: false,
                    data: {
                        cd_agend: cd_agend
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
                            var msg = 'Agendamento finalizado com sucesso!';
                            $('#sucessoTexto').html(msg);
                            $('#sucesso').modal('show');

                        } else {

                            $('#erro').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'ERRO ao finalizar o agendamento.';
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

        $("#alteracaoTexto").html('<b>Confirma a finalização do agendamento?</b>');
        $("#alteracao").modal("show");

    });

    // EDITAR O SERVIÇO
    $("a[id^=btnEdit]").click(function(e) {
        cd_agend = $(this).attr('cd_agend');

        $.ajax({
            type: 'POST',
            url: '/netcar/c_agendamento/editarAgendamento',
            cache: false,
            data: {
                cd_agend: cd_agend
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
});

