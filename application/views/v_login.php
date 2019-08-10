<div class="row">
    <!--	<h1>Tela Inicial</h1>-->
    <div class="col-md-4"></div>

    <div class="col-md-4" id="div-login">
        <fieldset id="fieldset-login">
            <form name="form-login" action="/netcar/c_login/logar" method="post">
                <legend class="text-black hr3">Login</legend>
                <div class="form-group">
                    <label class="control-label">Identidade</label>
                    <input class="form-control" type="text" name="idt" placeholder="Digite sua identidade" required />
                </div>
                <div class="form-group">
                    <label class="control-label">Senha</label>
                    <input class="form-control" type="password" name="senha" placeholder="Digite sua senha" required />
                </div>
                <!--<a href="">Não possuo cadastro.</a>-->
                <input type="hidden" name="acao" value="logar"/>
                <input type="submit" value="Entrar" class="btn btn-success pull-right"/>
            </form>
        </fieldset>
        <br><br>
        <?php
            if (isset($mensagem) && !empty($mensagem)) {
                echo '<div class="alert alert-danger">' . $mensagem . '</div>';
            }
        ?>
    </div>
    <!--	div corpo-->
    <div class="col-md-4"></div>

</div>


