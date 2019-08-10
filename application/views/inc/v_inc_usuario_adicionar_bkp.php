<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>"/>
<link rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>"/>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h2 class="titulo">Cadastrar usuário</h2>
        <form id="form_cad_usuario" action="" method="post">
            <legend class="text-black hr3">Dados do novo usuário</legend>
            <div class="form-group">
                <label class="control-label">Nome</label>
                <input class="form-control text text-uppercase" type="text" name="nome" required />
            </div>
            <div class="form-group">
                <label class="control-label">Identidade</label>
                <input class="form-control text text-uppercase" type="text" name="idt" required />
            </div>
            <div class="form-group">
                <label class="control-label">Endereço</label>
                <input class="form-control text text-uppercase" type="text" name="endereco" required />
            </div>
            <div class="form-group">
                <label class="control-label">Celular</label>
                <input class="form-control text text-uppercase" type="text" name="celular" required />
            </div>
            <div class="form-group">
                <label class="control-label">Tel Fixo</label>
                <input class="form-control text text-uppercase" type="text" name="fixo" required />
            </div>
            <?php
                if (validaPerfil(array(M_perfil::Gerente), $this->session->userdata('dados_usuario')->nivel)) {
                    ?>
                    <div class="form-group">
                        <label for="Perfil" class="control-label">Perfil</label>
                        <select class="form-control  text text-uppercase" name="nivel"  required>
                            <option value="">Selecione uma opção</option>
                            <option value="0">CLIENTE</option>
                            <option value="1">OPERADOR</option>
                            <option value="2">FINANCEIRO</option>
                            <option value="3">GERENTE</option>
                        </select>
                    </div>
                    <div class="form-inline">
                        <div class="form-group">
                            <label class="control-label">Senha</label>
                            <span id="dt_agenda">
                                <div class="controls">
                                    <input class="form-control" type="password" name="senha"/>
                                </div>
                            </span>
                        </div>
                        <div class="form-group pull-right">
                            <label class="control-label">Confirme a senha</label>
                            <span id="dt_agenda2">
                                <div class="controls">
                                    <input  class="form-control" type="password" name="confirma_senha"/>
                                </div>
                            </span>
                        </div>
                    </div>
                    <?php
                }
            ?>
            <input type="hidden" name="acao" value="cadastrar"/>
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
            senha = $("input[name=senha]").val();
            confirma_senha = $("input[name=confirma_senha]").val();
//            alert(nome);
            if (nome == '' || idt == '' || endereco == '' || celular == '' || fixo == '') {
                $('#erro').on('hidden.bs.modal', function(e) {
//                    window.location.reload();
                });
                $('#excluir').modal('hide');
                var msg = 'Os campos nome, identidade, endereço e telefone devem ser preenchidos.';
                $('#erroTexto').html(msg);
                $('#erro').modal('show');
            } else if ((senha !== '') && (senha !== confirma_senha)) {
                $('#erro').on('hidden.bs.modal', function(e) {
//                    window.location.reload();
                });
                $('#excluir').modal('hide');
                var msg = 'As senha não coincidem.';
                $('#erroTexto').html(msg);
                $('#erro').modal('show');
            } else {
                $.ajax({
                    type: 'POST',
                    url: '/netcar/c_usuario/cadastrarUsuario',
                    cache: false,
                    data: {
                        nome: nome,
                        idt: idt,
                        endereco: endereco,
                        celular: celular,
                        fixo: fixo,
                        nivel: nivel,
                        acao: acao,
                        senha: senha
                    },
                    beforeSend: function(xhr) {
                        xhr.overrideMimeType("text/plain; charset=UTF-8");
                    },
                    complete: function() {
                    },
                    success: function(data) {
                        if (data === '2') {
                            $('#erro').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'Identidade já cadastrada.';
                            $('#erroTexto').html(msg);
                            $('#erro').modal('show');
                        } else if (data === '1') {
                            $('#sucesso').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#alteracao').modal('hide');
                            var msg = 'Usuário cadastrado com sucesso.';
                            $('#sucessoTexto').html(msg);
                            $('#sucesso').modal('show');
                        } else {
                            $('#erro').on('hidden.bs.modal', function(e) {
                                window.location.reload();
                            });
                            $('#excluir').modal('hide');
                            var msg = 'ERRO ao cadastrar o usuário.';
                            $('#erroTexto').html(msg);
                            $('#erro').modal('show');
                        }
                    },
                    error: function() {
                        $("#erroTexto").html("Erro no sistema ao cadastrar, tente novamente.");
                        $("#erro").modal('show');
                        $().ready(function() {
                            setTimeout(function() {
                                $('#erro').modal('hide');
                            }, 2000);
                        });
                    }
                });

                e.preventDefault();
            }
        });
    });
</script>