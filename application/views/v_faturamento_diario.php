<div class="row">
    <?php
    if ($faturamento) {
        ?>
        <div class="col-md-2"></div>
        <div class="col-md-8"><h3 class="titulo text text-center">Faturamento do dia</h3></div>
        <table class="tabela table table-bordered table-condensed table-hover">
            <thead>
                <tr class="text text-center text-uppercase">
                    <th>ORD</th>
                    <th>DATA</th>
                    <th>HORARIO</th>
                    <th>SERVIÇO</th>
                    <th>TIPO DE VEÍCULO</th>
                    <th>VALOR</th>
                </tr>
            </thead>
            <?php
            $i = 0;
            foreach ($faturamento as $fatura) {
                $i = $i + 1;
                ?>
                <tr class="text text-center text-uppercase">
                    <td><?= $i ?></td>
                    <td><?= date('d/m/Y', strtotime($fatura->data)) ?></td>
                    <td><?= $fatura->horario ?></td>
                    <td><?= $fatura->servico ?></td>
                    <td><?= $fatura->tipo ?></td>
                    <td><?= "R$ " . $fatura->valor . ",00" ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="5" class="text text-center"><b>TOTAL</b></td>
                <td class="text text-center"><b><?= "R$ " . $total . ",00" ?></b></td>
            </tr>
        </table>
        <div class="col-md-2"></div>
    <?php } else { ?>
        <div class="col-md-3"></div>
        <div  id=""class="col-md-6" ><h3>Até o momento não existe faturamento, <?= date('d/m/y') ?>.</h3></div>
        <div class="col-md-3"></div>
    <?php } ?>
</div>
