<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h2 class="titulo"><?= $titulo ?></h2>
        <form id="form_edit_usuario" action="" method="post">
            <legend class="text-black hr3">Dados do usuário</legend>
            <div class="form-group">
                <label class="control-label">Nome</label>
                <input class="form-control text text-uppercase" type="text" name="nome" required value="<?= $usuario['nome'] ?>"/>
            </div>
            <div class="form-group">
                <label class="control-label">Identidade</label>
                <input class="form-control text text-uppercase" type="text" name="idt" required value="<?= $usuario['idt'] ?>"/>
            </div>
            <div class="form-group">
                <label class="control-label">Endereço</label>
                <input class="form-control text text-uppercase" type="text" name="endereco" required value="<?= $usuario['endereco'] ?>"/>
            </div>
            <div class="form-group">
                <label class="control-label">Celular</label>
                <input class="form-control text text-uppercase" type="text" name="celular" required value="<?= $usuario['celular'] ?>"/>
            </div>
            <div class="form-group">
                <label class="control-label">Tel Fixo</label>
                <input class="form-control text text-uppercase" type="text" name="fixo" required value="<?= $usuario['fixo'] ?>"/>
            </div>
            <?php
                if (validaPerfil(array(M_perfil::Gerente), $this->session->userdata('dados_usuario')->nivel)) {
                    ?>
                    <div class="form-group">
                        <label for="Perfil" class="control-label">Perfil</label>
                        <select class="form-control" name="nivel"  required>
                            <option value="<?= $usuario['nivel'] ?>">
                                <?php
                                echo $usuario['nivel'] == "10" ? "CLIENTE" : "";
                                echo $usuario['nivel'] == "1" ? "OPERADOR" : "";
                                echo $usuario['nivel'] == "2" ? "FINANCEIRO" : "";
                                echo $usuario['nivel'] == "3" ? "GERENTE" : "";
                                ?>
                            </option>
                            <option value="10">Cliente</option>
                            <option value="1">Operador</option>
                            <option value="2">Financeiro</option>
                            <option value="3">Gerente</option>
                        </select>
                    </div>
                    <?php
                }
            ?>


            <input type="hidden" name="acao" value="editar"/>
            <input type="hidden" name="cd_usuario" value="<?= $usuario['cd_usuario'] ?>"/>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>

<script>
    $(document).ready(function() {
        $("#salvarModal").click(function(e) {
            nome = $("input[name=nome]").val();
            idt = $("input[name=idt]").val();
            endereco = $("input[name=endereco]").val();
            celular = $("input[name=celular]").val();
            fixo = $("input[name=fixo]").val();
            nivel = $("select[name=nivel]").val();
            acao = $("input[name=acao]").val();
            cd_usuario = $("input[name=cd_usuario]").val();


            $.ajax({
                type: 'POST',
                url: '/netcar/c_usuario/editarUsuario',
                cache: false,
                data: {
                    nome: nome,
                    idt: idt,
                    endereco: endereco,
                    celular: celular,
                    fixo: fixo,
                    nivel: nivel,
                    acao: acao,
                    cd_usuario: cd_usuario
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
                        var msg = 'Usuário editado com sucesso.';
                        $('#sucessoTexto').html(msg);
                        $('#sucesso').modal('show');
                    } else {
                        $('#erro').on('hidden.bs.modal', function(e) {
                            window.location.reload();
                        });
                        $('#excluir').modal('hide');
                        var msg = 'ERRO ao editar usuário.';
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
    });
</script>