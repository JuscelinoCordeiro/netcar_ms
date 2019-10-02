<div id="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 text text-center"><h3 class="titulo"><?= $titulo ?></h3></div>
    <div class="col-md-2"></div>
    <table class="tabela table table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <th>ORD</th>
                <th>NOME</th>
                <th>IDENTIDADE</th>
                <th>ENDEREÇO</th>
                <th>CELULAR</th>
                <th>TEL FIXO</th>
                <th>PERFIL</th>
                <th>AÇÃO</th>
            </tr>
        </thead>
        <?php
            $i = 1;
            foreach ($usuarios->result() as $user) {
                ?>
                <tr>
                    <td class="text text-center text-uppercase"><?= $i ?></td>
                    <td class="text text-center text-uppercase"><?= $user->nome ?></td>
                    <td class="text text-center text-uppercase"><?= $user->idt ?></td>
                    <td class="text text-center text-uppercase"><?= $user->endereco ?></td>
                    <td class="text text-center text-uppercase"><?= $user->celular ?></td>
                    <td class="text text-center text-uppercase"><?= $user->fixo ?></td>
                    <td class="text text-center text-uppercase"><?= $user->perfil ?></td>
                    <td class="text text-center text-uppercase">
                        <a href="#" id="btnEdit<?= $user->cd_usuario ?>" cd_usuario="<?= $user->cd_usuario ?>"><img src="<?= base_url('assets/img/b_edit.png') ?>" alt="editar" title="Editar usuário" border="0"/></a>
                        <a class="excluir" id="btnExc<?= $user->cd_usuario ?>" cd_usuario="<?= $user->cd_usuario ?>"><img src="<?= base_url('assets/img/b_excluir.png') ?>" alt="excluir" title="Excluir usuário" border="0"/></a>
                    </td>
                </tr>

                <?php
                $i++;
            }
        ?>
    </table>
</div>


<script>
    $(document).ready(function() {
        $('a[id^=btnEdit]').click(function(e) {
            cd_usuario = $(this).attr('cd_usuario');
            $.ajax({
                type: 'POST',
                url: '/netcar/c_usuario/editarUsuario',
                cache: false,
                data: {
                    cd_usuario: cd_usuario
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
                    $("#erroTexto").html("Erro. Não foi possível editar o usuário.");
                    $("#erro").modal('show');
                }
            });
            e.preventDefault();
        });
    });


    $('a[id^=btnExc]').click(function() {

        cd_usuario = $(this).attr('cd_usuario');

        $('#excluir').on('shown.bs.modal', function(e) {

            $('#excluirModal').click(function() {
                $.ajax({
                    type: "POST",
                    url: '/netcar/c_usuario/excluirUsuario',
                    cache: false,
                    data: {cd_usuario: cd_usuario},
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
                            var msg = 'Usuário excluído com sucesso!';
                            $('#sucessoTexto').html(msg);
                            $('#sucesso').modal('show');

                        } else if (data === '404') {
                            $('#erro').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'ERRO ao excluir o usuário. <br>Serviço de Controle de Acesso Indisponível.<br> Tente mais tarde.';
                            $('#erroTexto').html(msg);
                            $('#erro').modal('show');

                        } else {

                            $('#erro').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'ERRO ao excluir o usuário.';
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

        $("#excluirTexto").html('<b>Confirma a exclusão do usuário?</b>');
        $("#excluir").modal("show");

    });
</script>