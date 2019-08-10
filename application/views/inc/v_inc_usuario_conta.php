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
            <input type="hidden" name="acao" value="atualizar"/>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>

<script>
    $(document).ready(function() {

//        $("#salvarModal").html("Atualizar dados");

        $("#salvarModal").click(function(e) {
            nome = $("input[name=nome]").val();
            idt = $("input[name=idt]").val();
            endereco = $("input[name=endereco]").val();
            celular = $("input[name=celular]").val();
            fixo = $("input[name=fixo]").val();
            acao = $("input[name=acao]").val();

            $.ajax({
                type: 'POST',
                url: '/netcar/c_usuario/contaUsuario',
                cache: false,
                data: {
                    nome: nome,
                    idt: idt,
                    endereco: endereco,
                    celular: celular,
                    fixo: fixo,
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
                        var msg = 'Dados atualizados com sucesso.';
                        $('#sucessoTexto').html(msg);
                        $('#sucesso').modal('show');
                    } else {
                        $('#erro').on('hidden.bs.modal', function(e) {
                            window.location.reload();
                        });
                        $('#excluir').modal('hide');
                        var msg = 'ERRO ao atualizar os dados.';
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