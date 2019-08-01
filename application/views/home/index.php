<!DOCTYPE html>
<html>
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="SISTEMA DE GESTÃO DE PROVAS ONLINE">
        <meta name="auhor" content="Silvio Silva de Souza">
        <meta name="mail" content="silvio.souza@seculomanaus.com.br">
        <title><?=FLG_BANCO?> :: SISTEMA DE GESTÃO ACADÊMICA ONLINE</title>
        <meta charset="utf-8">
        <!-- Vendor styles -->
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
        <!-- Vendor scripts -->
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/prova.js?v='.time().'') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.fullscreen.js') ?>"></script>

    </head>
    <!-- <body> -->
    <body onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..Não tente isso .. '; return true;">
      
        <div class="color-line" style="height: 20px"></div>
        <div class="col-sm-12 col-xs-offset-1" style="padding: 10px 0px">
            <img width='100' src="<?=base_url('assets/images/logo.png')?>">
        </div>
       
        <div class="row">
            <br><br><br>
            <div class="col-xs-2 col-xs-offset-1">
                <div class="hpanel hyellow">
                    <div class="panel-body text-center">
                        
                        <img width='50' src="http://server01/academico/usuarios/foto?codigo=<?=$this->session->userdata('PVO_USER')?>" class="img-rounded">
                        <h5><?=$this->session->userdata('PVO_NOME')?></h5>
                        <small class="text-muted">
                            <?= $questao->TITULO ?>
                        </small>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-danger2 form-control" href="<?=base_url('usuario/logout')?>"> SAIR DO SISTEMA</a>        
                    </div>
                </div>
            </div>

            <div class="col-xs-8">
                <div class="hpanel hyellow">

                        <?php
                        $ativar = false;
                        $proximo = false;
                        
                        foreach($listar as $q){ ?>
                        <form action='<?=base_url('home/verifica_acesso')?>' method="POST">
                            <div class="col-sm-4 border-right border-bottom">
                                <div class="panel-footer">
                                    <?php 
                                 
                                    $tempo_esgotado = 0;
                                    $hora_atual = new DateTime();
                                   // echo $hora_atual->format('H:i'); 
              
                                    echo $hora_inicio = new DateTime();
                                    echo $hr_inicio = new DateTime($q->HR_INICIO);
                                    echo $hora_fim = new DateTime ($q->HR_FIM);
                                    echo $sub_min = new DateInterval('PT5M');
                                    
                                    //$hora_inicio = $hr_inicio->sub($sub_min);
                                    
                                    $hora_inicio->format('H:i');
                                  
                                   /* if ($hora_inicio > $hora_atual){
                                        $tempo_esgotado = 2;
                                    }  else {
                                        if(($hora_atual >= $hora_inicio) && ($hora_atual <= $hora_fim)){
                                            $tempo_esgotado = 0;
                                        }else{
                                            $tempo_esgotado = 1;
                                        }
                                    }*/


                                    if ($hr_inicio > $hora_atual){
                                        $tempo_esgotado = 2;
                                    }  else {
                                        if(($hora_atual >= $hr_inicio) && ($hora_atual <= $hora_fim)){
                                            $tempo_esgotado = 0;
                                        }else{
                                            $tempo_esgotado = 1;
                                        }
                                    }

                                      
                                    ?>

                                    PROVA: <strong><?= $q->NUM_PROVA?></strong><br>
                                    TIPO: <strong><?= $q->DC_TIPO_PROVA?></strong><br>
                                    INÍCIO: <strong><?= $q->HR_INICIO?></strong><br>
                                    FIM: <strong><?= $q->HR_FIM?></strong><br>
                                    SÉRIE: <strong><?= $q->ORDEM_SERIE; ?>ª</strong><br>
                                
                                </div>
                                <div class="col-sm-12 bg-danger text-center" style="height: 50px">
                                    <h6><?=$q->DISCIPLINAS?></h6>
                                </div>
                                <div class="panel-footer">
                                    <?php 
                                    if ($q->FEZ_PROVA == 0){
                                        if($ativar == false && ($tempo_esgotado == 0 || $proximo == true)){
                                            $ativar = TRUE;
                                            echo "<input type='hidden' name='cesProva' value='".$q->CD_PROVA_VERSAO."'/>
                                                  <input type='hidden' name='materia' value='".$q->DISCIPLINAS."'/>
                                                  <input type='hidden'   name='serie' value='".$q->ORDEM_SERIE."' />
                                                  <button class='btn btn-info form-control' type='submit'>Iniciar</button>";
                                        }else{
                                            echo "<button class='btn btn-warning form-control' disabled='disabled'>Aguardando Início</button>";
                                        }
                                    }else{
                                        $proximo = true;
                                        echo "<button class='btn btn-success form-control' disabled='disabled'>Realizada</button>";
                                    }
                                   ?>
                                </div>
                            </div>
                        </form>
                           
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if(isset($mensagens)) echo $mensagens; ?>
        <div id="footer">
            <div class="bg-primary" style="position: fixed; bottom: 0px; width:100%; z-index: 9999999999999">
                <div class="color-line"></div>
            </div>
        </div>
     </body>
</html>