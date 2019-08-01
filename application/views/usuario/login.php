<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="SISTEMA DE GESTÃO DE PROVAS ONLINE">
        <meta name="auhor" content="Silvio Silva de Souza">
        <meta name="mail" content="silvio.souza@seculomanaus.com.br">
        <title><?= FLG_BANCO ?> :: SISTEMA DE GESTÃO ACADÊMICA ONLINE</title>
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/bootstrap.css" />
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/font-awesome.min.css" />
        <link rel="stylesheet" href="<?= base_url('assets/css/') ?>/style.css">
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>

    </head>
    <body onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..Não tente isso .. '; return true;">
        <div class="wrapper">
            <div class="col-sm-4"></div>
            <div class="col-sm-3 block-center mt-xl wd-xl" style="top: 150px">
                <!-- START panel-->
                <div class=" panel-dark panel-flat">
                    <div class="panel-heading text-center">
                        <a href="#">
                            <img width="100%" src="<?= base_url('assets/images/logo.png') ?>" alt="Image" class="block-center">
                        </a>
                    </div>
                    <div class="panel-body">
                        <form action="<?= base_url('usuario/acesso') ?>" method="POST" role="form" data-parsley-validate="" novalidate="novalidate" class="mb-lg">
                            <div class="input-group has-feedback">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                            
                                <input value="<?= set_value('lguser') ?>" id="lguser" type="text" name="lguser" placeholder=" Matrícula " autocomplete="off" required class="form-control">
                                <span data-toggle="btnLimpaUsuario" class="input-group-addon btn">
                                    <i class="fa fa-angle-double-left"></i>
                                </span>
                            </div>
                            <?= form_error('lguser', ALERT_REQUIRED); ?>
                            <br>
                            <div class="input-group has-feedback">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-lock"></i>
                                </span>
                                <input id="lgpass" name="lgpass" type="password" placeholder=" Senha " class="form-control">
                                <span data-toggle="btnLimpaSenha" class="input-group-addon btn">
                                    <i class="fa fa-angle-double-left"></i>
                                </span>
                            </div>
                            <?= form_error('lgpass', ALERT_REQUIRED); ?>
                            <br>
                            <input type="hidden" value="<?= base64_encode(date('dmYhmi')) ?>" id="lgToken" name="lgToken" type="text">
                            <button class="btn btn-block btn-primary mt-lg" type="submit">
                                Acessar
                            </button>
                        </form>
                    </div>
                </div>
                <!-- END panel-->
                <div class="p-lg text-center">
                    <span>&copy; 2018 - <?= FLG_BANCO ?></span>
                </div>
            </div>
            <div class="col-sm-4"></div>

        </div>

        <script type="text/javascript">
            $('[data-toggle="btnLimpaUsuario"]').on('click',function() {
                 $('input[name="lguser"]').val('');
            });
            $('[data-toggle="btnLimpaSenha"]').on('click',function() {
                 $('input[name="lgpass"]').val('');
            });
        </script>   
    </body>
</html>