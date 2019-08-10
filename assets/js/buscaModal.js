$(document).ready(function () {

    $("#btnBuscar").click(function () {
        // $("#modalTitulo").html('Ficha de Inscri��o');
        // $("#modalTexto").html('<h1>teste de modal</h1>');
        // $('#modal').on('hidden.bs.modal', function (e) {
        //     window.location.reload();
        // });
        // $("#modal").modal('show');
        valor = $("select").val();
        if (valor != "") {

            alert(valor);
        } else {
            // alert("ERRO! Valor vazio.");
            $("#erroTexto").html('Ocorreu um erro no sistema.');
            $("#erro").modal("show");
        }
    });

    $("#btnMyModal").click(function () {
        $("#modalTexto").html("<h1>Chamndo modal</h1>");
        $("#modal").modal();
    });


// BUSCAR MUNICIPIOS POR ESTADO
    $("#btnBuscarMuniEst").click(function (e) {
        valor = $("select[name=listaEstado]").val();

        if (valor == "") {
            //     // alert(valor);
            alert("ERRO! Nenhum estado selecionado.");
        } else {
            // alert(valor);
            $.ajax({
                type: 'POST',
                url: 'c_inicio/municipiosPorEstado',
                cache: false,
                data: {
                    valor: valor
                },
                beforeSend: function (xhr) {
                    xhr.overrideMimeType("text/plain; charset=UTF-8");
                },
                complete: function () {
                },
                success: function (data) {
                    $("#visualizarTexto").html(data);
                    $("#visualizar").modal();
                },
                error: function () {
                    $("#erroTexto").html("erro");
                    $("#erro").modal('show');
                }
            });
            e.preventDefault();
        } //fim do else
    });

    // BUSCAR ESTADOS POR REGIAO
    $("#btnBuscarEst").click(function (e) {
        valor = $("select[name=listaRegiao]").val();

        $.ajax({
            type: 'POST',
            url: 'c_inicio/estadosPorRegiao',
            cache: false,
            data: {
                valor: valor
            },
            beforeSend: function (xhr) {
                xhr.overrideMimeType("text/plain; charset=UTF-8");
            },
            complete: function () {
            },
            success: function (data) {
                $("#visualizarTexto").html(data);
                $("#visualizar").modal('show');
            },
            error: function () {
                $("#erroTexto").html("erro");
                $("#erro").modal('show');
            }
        });
        e.preventDefault();
    });


    // CADASTRAR MUNICIPIOS
    $("#btnCadBairro").click(function (e) {
        valor = $(this).val();

        $.ajax({
            type: 'POST',
            url: 'c_inicio/cadastrarBairro',
            cache: false,
            data: {
                valor: valor
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


});


