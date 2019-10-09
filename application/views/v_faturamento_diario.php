<style type="text/css">
    /*    .btn-acao{
            display: none;
        }*/
</style>
<div class="row fatura">
    <?php
        if ($faturamento) {
            ?>
            <div class="col-md-2"></div>
            <div class="col-md-8"><h3 class="titulo text text-center">Faturamento do dia</h3></div>
            <table id="tbl-faturamento" class="tabela table table-bordered table-condensed table-hover">
                <thead>
                    <tr class="text text-center text-uppercase">
                        <th>ORD</th>
                        <th>DATA</th>
                        <th>HORARIO</th>
                        <th>SERVIÇO</th>
                        <th>TIPO DE VEÍCULO</th>
                        <th>VALOR</th>
                        <th class="btn-acao">AÇÃO</th>
                    </tr>
                </thead>
                <?php
                $i = 0;
                foreach ($faturamento as $fatura) {
                    $i = $i + 1;
                    ?>
                    <tr id ="<?= $i ?>"class="text text-center text-uppercase">
                        <td class="dados"><?= $i ?></td>
                        <td class="dados"><?= date('d/m/Y', strtotime($fatura->data)) ?></td>
                        <td class="dados"><?= $fatura->horario ?></td>
                        <td class="dados"><?= $fatura->servico ?></td>
                        <td class="dados"><?= $fatura->tipo ?></td>
                        <td class="dados"><?= "R$ " . $fatura->valor . ",00" ?></td>
                        <td class="btn-acao noprint">
                            <a href="#" id="btnRel<?= $fatura->cd_fatura ?>" cd_linha="<?= $i ?>" cd_fatura="<?= $fatura->cd_fatura ?>"><img src="<?= base_url('assets/img/b_pdf.png') ?>" height="20" alt="imprimir_relatorio" title="Imprimir Fatura" border="0"/></a>
                        </td>
                    </tr>
                <?php } ?>
                <tr class="text text-center">
                    <td colspan="5" class="text text-center"><b>TOTAL</b></td>
                    <td class="text text-center"><b><?= "R$ " . $total . ",00" ?></b></td>
                    <td class="text text-center btn-acao noprint">
                        <a href="#" id="btnTotal"><img src="<?= base_url('assets/img/b_pdf.png') ?>" height="20" alt="imprimir_relatorio" title="Imprimir Faturamento Total" border="0"/></a>
                    </td>
                </tr>
            </table>
            <div class="col-md-2"></div>
        <?php } else { ?>
            <div class="col-md-3"></div>
            <div  id=""class="col-md-6" ><h3>Até o momento não existe faturamento, <?= date('d/m/y') ?>.</h3></div>
            <div class="col-md-3"></div>
        <?php } ?>
</div>

<script>
    // imprimir comprovante
    $("a[id^=btnRel]").click(function(e) {
        cd_fatura = $(this).attr('cd_fatura');
//        $('.btn-acao').remove();
////        conteudo = document.getElementById(id).innerHTML();
//        conteudo = $(this).parent('tr').html();
//        console.log(conteudo);
//        alert(conteudo);
//        exit();
        $.ajax({
            type: 'POST',
            url: '/netcar/c_faturamento/gerarComprovante',
//            contentType: 'application/json',
            cache: false,
            data: {
                cd_fatura: cd_fatura
            },
            beforeSend: function(xhr) {
                xhr.overrideMimeType("text/plain; charset=UTF-8");
            },
            complete: function() {
            },
            success: function(data) {
                $("#visualizarTexto").html(data);
                $("#visualizar").modal('show');
                $('#visualizar').on('hidden.bs.modal', function(e) {
                    window.location.reload();
                });
            },
            error: function() {
                $("#erroTexto").html("erro");
                $("#erro").modal('show');
            }
        });
        e.preventDefault();
    });
    //=======================================
    // imprimir faturamento
    $("a[id^=btnTotal]").click(function(e) {
        $('.btn-acao').remove();
        conteudo = $('#tbl-faturamento').html();
        titulo = $('.titulo').text();
        $.ajax({
            type: 'POST',
            url: '/netcar/c_faturamento/imprimirFaturamento',
//            contentType: 'application/json',
            cache: false,
            data: {
                conteudo: conteudo,
                titulo: titulo
            },
            beforeSend: function(xhr) {
                xhr.overrideMimeType("text/plain; charset=UTF-8");
            },
            complete: function() {
            },
            success: function(data) {
                $("#visualizarTexto").html(data);
                $("#visualizar").modal('show');
                $('#visualizar').on('hidden.bs.modal', function(e) {
                    window.location.reload();
                });
            },
            error: function() {
                $("#erroTexto").html("erro");
                $("#erro").modal('show');
            }
        });
        e.preventDefault();
    });


    //=======================================
    //=======================================
//    // imprimir comprovante
//    $("a[id^=btnRel]").click(function(e) {
//        cd_fatura = $(this).attr('cd_fatura');
//
//        $.ajax({
//            type: 'POST',
//            url: '/netcar/c_faturamento/imprimirFatura',
////            contentType: 'application/json',
//            cache: false,
//            data: {
//                cd_fatura: cd_fatura
//            },
//            beforeSend: function(xhr) {
//                xhr.overrideMimeType("text/plain; charset=UTF-8");
//            },
//            complete: function() {
//            },
//            success: function(data) {
//                $("#modalTexto").html(data);
//                $("#modal").modal('show');
//            },
//            error: function() {
//                $("#erroTexto").html("erro");
//                $("#erro").modal('show');
//            }
//        });
//        e.preventDefault();
//    });


    //=======================================
//
//
//    //EXCLUIR O SERVIÇO
//    $('a[id^=btnExc]').click(function() {
//
//        id = $(this).attr('id_veiculo');
//
//        $('#excluir').on('shown.bs.modal', function(e) {
//
//            $('#excluirModal').click(function() {
//                $.ajax({
//                    type: "DELETE",
//                    url: '/netcar/c_veiculo/excluirVeiculo',
//                    contentType: 'application/json',
//                    cache: false,
//                    data: {id: id},
//                    beforeSend: function(xhr) {
//                        xhr.overrideMimeType("text/plain; charset=UTF-8");
//                    },
//                    complete: function() {
//                    },
//                    success: function(data) {
//                        if (data === '1') {
//
//                            $('#sucesso').on('hidden.bs.modal', function(e) {
//                                window.location.reload();
//                            });
//                            $('#excluir').modal('hide');
//                            var msg = 'Veículo excluído com sucesso!';
//                            $('#sucessoTexto').html(msg);
//                            $('#sucesso').modal('show');
//
//                        } else {
//
//                            $('#erro').on('hidden.bs.modal', function(e) {
//                                window.location.reload();
//                            });
//                            $('#excluir').modal('hide');
//                            var msg = 'ERRO ao excluir o veículo.';
//                            $('#erroTexto').html(msg);
//                            $('#erro').modal('show');
//                        }
//                    },
//                    error: function() {
//                        $("#erro").html('Ocorreu um erro no sistema.');
//                        $("#erro").dialog("open");
//                    }
//                });
//            });
//
//        });
//
//        $("#excluirTexto").html('<b>Confirma a exclusão do veículo?</b>');
//        $("#excluir").modal("show");
//
//    });

</script>