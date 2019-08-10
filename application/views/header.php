<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    isset($titulo) ? $titulo : $titulo = "NetCar - SLA";
    $CI = &get_instance();
    $CI->load->model('m_perfil');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title><?= $titulo ?></title>

        <!--	ARQUIVOS DE ESTILO	-->
        <link  type="text/css" rel="stylesheet" href="<?= base_url('assets/css/estilo.css') ?>">
        <link  type="text/css" rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>">
        <link  type="text/css" rel="stylesheet" href="<?= base_url('assets/css/bootstrap-theme.css') ?>">
        <link  type="text/css" rel="stylesheet" href="<?= base_url('assets/js/jquery-ui/css/custom-theme/jquery-ui-1.10.4.custom.css') ?>"/>
        <link  type="text/css" rel="stylesheet" href="<?= base_url('assets/css/clockpicker.css') ?>"/>
        <link  type="text/css" rel="stylesheet" href="<?= base_url('assets/js/spry/SpryValidationTextField.css') ?>" />

        <!--	ARQUIVOS DE SCRIPT	-->
        <script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/bootstrap.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/npm.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/buscaModal.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/clockpicker.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/spry/SpryValidationTextField.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery-ui/js/jquery-ui-1.10.4.custom.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/js_navbar.js') ?>"></script>
    </head>
    <body>
        <div id="main" class="container-fluid">
            <div class="row">
                <div id="header">
                    <div class="nome_sistema">NetCAR</div>
                    <div class="apresentacao">Serviços de Limpeza Automotiva</div>
                </div>
                <!-- DIV DE VISUALIZACAO PARA AS VIEWS QUE UTILIZAM MODAL -->
                <div class="modal fade text-primary" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="visualizarTitulo"> ... </h4>
                            </div>
                            <div id="visualizarTexto" class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button id="visualizarModal" type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- DIV DE JANELA PADRAO PARA AS VIEWS QUE UTILIZAM MODAL -->
                <div class="modal fade text-primary" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="modalTitulo"> ... </h4>
                            </div>
                            <div id="modalTexto" class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer" id="modalSalvar">
                                <button id="fecharModal" type="button" class="btn btn-default" data-dismiss="modal">Fechar
                                </button>
                                <button id="salvarModal" type="button" class="btn btn-primary"
                                        data-loading-text="Carregando...">Salvar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL PADRAO BOOTSTRAP -->
                <div class="modal fade" id="alteracao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="alteracaoTitulo">Confirma alteração</h4>
                            </div>
                            <div id="alteracaoTexto" class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <button id="alteracaoModal" type="button" class="btn btn-primary">Salvar alteração</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- div de ERRO -->
                <div class="modal fade text-danger" id="erro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="erroTitulo">Erro!</h4>
                            </div>
                            <div id="erroTexto" class="modal-body alert alert-danger">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <!--<button type="button" class="btn btn-primary">Salvar mudan�as</button>-->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- div de Sucesso -->
                <div class="modal fade text-danger" id="sucesso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-success" id="sucessoTitulo">Sucesso</h4>
                            </div>
                            <div id="sucessoTexto" class="modal-body alert alert-success">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                <!--<button type="button" class="btn btn-primary">Salvar mudan�as</button>-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- DIV DE JANELA DE EXCLUSÃO PARA AS VIEWS QUE UTILIZAM MODAL -->
                <div class="modal fade text-primary" id="excluir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-danger" id="excluirTitulo"> Exclusão </h4>
                            </div>
                            <div id="excluirTexto" class="modal-body  text-danger">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button id="cancelarModal" type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button id="excluirModal" type="button" class="btn btn-danger" data-loading-text="Carregando...">Excluir</button>
                            </div>
                        </div>
                    </div>
                </div>
