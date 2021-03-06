<div id="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 text text-center"><h3 class="titulo"><?= $titulo ?></h3></div>
    <div class="col-md-2"></div>
    <table class="tabela table table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th>ORD</th>
                <th>SERVIÇO</th>
                <th>TIPO DE VEÍCULO</th>
                <th>PREÇO</th>
                <th>AÇÃO</th>
            </tr>
        </thead>
        <?php
            $i = 1;

            foreach ($tarifas->result() as $tarifa) {
                if ($veiculos != M_http_code::not_found) {
                    foreach ($veiculos as $veiculo) {
                        if ($tarifa->cd_tpveiculo == $veiculo->id) {
                            ?>
                            <tr>
                                <td class="text text-center text-uppercase"><?= $i ?></td>
                                <td class="text text-center text-uppercase"><?= $tarifa->servico ?></td>
                                <td class="text text-center text-uppercase"><?= $veiculo->tipo ?></td>
                                <td class="text text-center text-uppercase">
                                    <?= $tarifa->preco ? "R$ " . $tarifa->preco . ",00" : "<span class=\"label label-info\">Configurar preço</span>" ?></td>
                                <td class="text text-center text-uppercase"">
                                    <a href="#" id="btnEdit<?= $tarifa->cd_servico ?>" cd_tpservico="<?= $tarifa->cd_servico ?>" cd_tpveiculo="<?= $tarifa->cd_tpveiculo ?>">
                                        <img src="<?= base_url('assets/img/b_edit.png') ?>" alt="editar" title="Editar" border="0">
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                } else {
                    ?>
                    <tr>
                        <td class="text text-center text-uppercase"><?= $i ?></td>
                        <td class="text text-center text-uppercase"><?= $tarifa->servico ?></td>
                        <td class="text text-center text-uppercase"><span class="text text-danger"><b>Serviço Indisponível</b></span></td>
                        <td class="text text-center text-uppercase">
                            <?= $tarifa->preco ? "R$ " . $tarifa->preco . ",00" : "<span class=\"label label-info\">Configurar preço</span>" ?></td>
                        <td class="text text-center text-uppercase">
                            <?php
                            if ($veiculos != M_http_code::not_found) {
                                ?>
                                <a href="#" id="btnEdit<?= $tarifa->cd_servico ?>" cd_tpservico="<?= $tarifa->cd_servico ?>" cd_tpveiculo="<?= $tarifa->cd_tpveiculo ?>">
                                    <img src="<?= base_url('assets/img/b_edit.png') ?>" alt="editar" title="Editar" border="0">
                                </a>
                                <?php
                            } else {
                                echo '<span class="text text-danger"><b>Indisponível</b></span>';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                $i++;
            }
        ?>
    </table>
</div>

<script>
// EDITAR O SERVIÇO
    $("a[id^=btnEdit]").click(function(e) {
        cd_servico = $(this).attr('cd_tpservico');
        cd_tpveiculo = $(this).attr('cd_tpveiculo');
        $.ajax({
            type: 'POST',
            url: '/netcar/c_tarifa/editarTarifa',
            cache: false,
            data: {
                cd_servico: cd_servico,
                cd_tpveiculo: cd_tpveiculo
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
</script>